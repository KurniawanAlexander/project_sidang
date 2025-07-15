<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\Clustering;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;
use Illuminate\Support\Facades\Http;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;


class ClusteringController extends Controller
{
    // Menampilkan daftar clustering
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $clustering = Clustering::where('judul_proposal', 'like', '%' . $search . '%')->paginate(20); // Ganti 10 dengan jumlah yang diinginkan
        } else {
            $clustering = Clustering::paginate(20); // Jika tidak ada pencarian, tampilkan semua mahasiswa
        }

        // $clustering = clustering::all(); // Ambil semua data clustering
        return view('admin.clustering.index', compact('clustering'));
    }

    // Menampilkan form untuk menambahkan clustering
    public function create()
    {

        return view('admin.clustering.create');
    }

    // // Menyimpan clustering baru
    public function store(Request $request)

    {
        $request->validate([
            'mahasiswa' => 'required',
            'judul_proposal' => 'required',
            'abstrak' => 'required',
            'kata_kunci' => 'required',
            'nim' => 'required',
            'dosen' => 'nullable',
            'keahlian_dosen' => 'nullable',
            'tahun' => 'required',
            'status_proposal' => 'required',
            'keterangan' => 'nullable',
        ]);

        clustering::create($request->all());
        return redirect()->route('clustering.index')->with('success', 'clustering berhasil ditambahkan.');
    }


    // Menampilkan clustering tertentu
    public function show(clustering $clustering)
    {
        return view('admin.clustering.show', compact('clustering'));
    }

    // Menampilkan form untuk mengedit clustering
    public function edit(clustering $clustering)
    {
        return view('admin.clustering.edit', compact('clustering'));
    }

    // Memperbarui clustering yang sudah ada
    public function update(Request $request, Clustering $clustering)
    {
        $request->validate([
            'mahasiswa'        => 'required',
            'judul_proposal'   => 'required',
            'abstrak'          => 'required',
            'kata_kunci'       => 'required',
            'nim'              => 'required',
            'dosen'            => 'nullable',
            'keahlian_dosen'   => 'nullable',
            'tahun'            => 'required',
            'status_proposal'  => 'required',
            'keterangan'       => 'nullable',
        ]);

        $clustering->update($request->all());

        return redirect()->route('clustering.index')->with('success', 'Data clustering berhasil diperbarui.');
    }


    // Menghapus clustering
    public function destroy(clustering $clustering)
    {
        $clustering->delete();
        return redirect()->route('clustering.index')->with('success', 'clustering berhasil dihapus.');
    }




    public function klaster()
    {
        $proposals = Clustering::all(['id', 'judul_proposal']);

        // Step 1: Preprocessing
        $documents = [];
        foreach ($proposals as $p) {
            $text = strtolower(strip_tags($p->judul_proposal));
            if (!empty(trim($text))) {
                $documents[] = [
                    'id' => $p->id,
                    'tokens' => explode(' ', preg_replace('/[^a-z0-9\s]/', '', $text))
                ];
            }
        }

        if (count($documents) < 2) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak cukup.'], 400);
        }

        // Step 2: Hitung TF
        $tf = [];
        $df = [];
        foreach ($documents as $doc) {
            $counts = array_count_values($doc['tokens']);
            $tfRow = [];
            foreach ($counts as $term => $count) {
                $tfRow[$term] = $count / count($doc['tokens']);
                $df[$term] = ($df[$term] ?? 0) + 1;
            }
            $tf[] = $tfRow;
        }

        $N = count($documents);
        $idf = [];
        foreach ($df as $term => $freq) {
            $idf[$term] = log($N / $freq, 10);
        }

        // Step 3: TF-IDF matrix
        $vocab = array_keys($idf);
        $vectors = [];
        foreach ($tf as $tfRow) {
            $vector = [];
            foreach ($vocab as $term) {
                $vector[] = ($tfRow[$term] ?? 0) * $idf[$term];
            }
            $vectors[] = $vector;
        }

        // Step 4: K-Means (manual)
        $k = 3;
        $maxIter = 100;
        $centroids = array_slice($vectors, 0, $k);
        $clusters = [];

        for ($iter = 0; $iter < $maxIter; $iter++) {
            $clusters = array_fill(0, $k, []);
            foreach ($vectors as $i => $vector) {
                $distances = array_map(fn($c) => $this->euclideanDistance($vector, $c), $centroids);
                $minIndex = array_keys($distances, min($distances))[0];
                $clusters[$minIndex][] = $i;
            }

            $newCentroids = [];
            foreach ($clusters as $cluster) {
                if (count($cluster) == 0) {
                    $newCentroids[] = $centroids[array_rand($centroids)];
                    continue;
                }
                $sum = array_fill(0, count($vectors[0]), 0);
                foreach ($cluster as $i) {
                    foreach ($vectors[$i] as $j => $val) {
                        $sum[$j] += $val;
                    }
                }
                $count = count($cluster);
                $newCentroids[] = array_map(fn($val) => $val / $count, $sum);
            }

            if ($centroids == $newCentroids) break;
            $centroids = $newCentroids;
        }

        // Step 5: Simpan ke DB
        foreach ($clusters as $clusterIndex => $indexes) {
            foreach ($indexes as $i) {
                Clustering::where('id', $documents[$i]['id'])->update([
                    'klaster' => $clusterIndex
                ]);
            }
        }

        $data = Clustering::all();

        $K0 = $data->where('klaster', '0');
        $K1 = $data->where('klaster', '1');
        $K2 = $data->where('klaster', '2');

        $cek = [
            'Cluster 0' => $K0->pluck('judul_proposal')->toArray(),
            'Cluster 1' => $K1->pluck('judul_proposal')->toArray(),
            'Cluster 2' => $K2->pluck('judul_proposal')->toArray(),
        ];

        // Bangun prompt dari hasil cluster
        $prompt = "Berikan label/topik singkat dan jelas namun spesifik tanpa berbelit belit untuk masing-masing klaster berdasarkan judul-judul berikut:\n\n";
        foreach ($cek as $cluster => $titles) {
            $prompt .= "$cluster:\n";
            foreach ($titles as $title) {
                $prompt .= "- $title\n";
            }
            $prompt .= "\n";
        }

        // Kirim ke Grok AI
        $result = $this->callGeminiAi($prompt);
        // Ambil baris yang ada pattern "Cluster N: Label"
        preg_match_all('/\*\s+\*\*Cluster (\d+): (.+?)\*\*/', $result, $matches, PREG_SET_ORDER);

        $labels = [];
        foreach ($matches as $match) {
            $clusterIndex = $match[1];
            $label = trim($match[2]);
            $labels[$clusterIndex] = $label;
        }

        // Ambil dulu semua klaster unik dan simpan mapping
        $mapping = [];
        foreach ($labels as $clusterIndex => $label) {
            $mapping[$clusterIndex] = $label;
        }

        // Update satu per satu berdasarkan clusterIndex
        foreach ($mapping as $clusterIndex => $label) {
            Clustering::where('klaster', $clusterIndex)->update([
                'label' => $label,
            ]);
        }

        return back()->with('success', 'Clustering data berhasil dengan labelisasi AI');
    }

    private function callGeminiAi($prompt)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            return 'Gagal memanggil Gemini: ' . $response->body();
        }

        $result = $response->json();
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada respon';
    }
    private function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
