<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    /**
     * Menampilkan daftar tugas akhir.
     */
    public function index()
    {
        if (Gate::allows('isMahasiswa')) {

            $mahasiswa = Mahasiswa::where('nama', Auth::user()->name)->first();

            if (!$mahasiswa) {

                return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
            }

            $tugasakhirs = TugasAkhir::where('mahasiswa_id', $mahasiswa->id)->get();
        } elseif (Gate::allows('isKaprodi')) {
            $dosen = Dosen::where('nama_dosen', Auth::user()->name)->first();
            if (!$dosen) {

                return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
            }
            $tugasakhirs = TugasAkhir::all();
        }
        return view('tugasakhir.index', compact('tugasakhirs'));
    }

    /**
     * Untuk mengunduh dokumen tugas akhir.
     */
    public function download($id)
    {
        $data = TugasAkhir::findOrFail($id);
        $filePath = storage_path('app/public/' . $data->dokumen);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    /**
     * Menampilkan detail tugas akhir.
     */
    public function detail($id)
    {
        $tugasakhir = TugasAkhir::findOrFail($id);
        return view('tugasakhir.detail', compact('tugasakhir'));
    }

    /**
     * Menampilkan formulir untuk menambahkan tugas akhir baru.
     */
    public function create()
    {
        return view('tugasakhir.create');
    }

    /**
     * Menyimpan tugas akhir baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'mahasiswa_id' => 'required|string|max:255', // Ganti input untuk menerima nama mahasiswa
            'judulproposal1' => 'required|string|max:255',
            'judulproposal2' => 'required|string|max:255',
            'dokumen' => 'required|mimes:pdf|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Cari mahasiswa berdasarkan nama yang diinputkan
        $mahasiswa = Mahasiswa::where('nama', $validatedData['mahasiswa_id'])->first();

        // Cek apakah mahasiswa ditemukan
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Upload file dokumen
        $dokumenPath = $request->file('dokumen')->store('dokumen_tugasakhir', 'public');

        // Simpan data Tugas Akhir
        $tugasAkhir = new TugasAkhir();
        $tugasAkhir->mahasiswa_id = $mahasiswa->id; // Gunakan ID mahasiswa
        $tugasAkhir->judulproposal1 = $validatedData['judulproposal1'];
        $tugasAkhir->judulproposal2 = $validatedData['judulproposal2'];
        $tugasAkhir->dokumen = $dokumenPath;
        $tugasAkhir->keterangan = $validatedData['keterangan'];

        if ($tugasAkhir->save()) {
            return redirect()->route('tugasakhir.index')->with('success', 'Tugas Akhir berhasil diajukan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan Tugas Akhir.');
        }
    }

    public function show(TugasAkhir $tugasakhir)
    {
        return view('tugasakhir.detail', compact('tugasakhir'));
    }


    /**
     * Menampilkan formulir untuk mengedit tugas akhir.
     */
    public function edit($id)
    {
        $tugasakhir = TugasAkhir::findOrFail($id);
        return view('tugasakhir.edit', compact('tugasakhir'));
    }

    /**
     * Memperbarui tugas akhir di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'mahasiswa_id' => 'required|string|max:255', // Menerima nama mahasiswa dari form
            'judulproposal1' => 'required|string|max:255',
            'judulproposal2' => 'required|string|max:255',
            'dokumen' => 'nullable|mimes:pdf|max:2048', // File dokumen tidak wajib di-update
            'keterangan' => 'nullable|string'
        ]);

        // Cari Tugas Akhir berdasarkan ID
        $tugasakhir = TugasAkhir::findOrFail($id);

        // Cari mahasiswa berdasarkan nama yang diinput
        $mahasiswa = Mahasiswa::where('nama', $validatedData['mahasiswa_id'])->first();

        // Cek apakah mahasiswa ditemukan
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        }

        // Update data Tugas Akhir
        $tugasakhir->mahasiswa_id = $mahasiswa->id; // Gunakan ID mahasiswa yang benar
        $tugasakhir->judulproposal1 = $validatedData['judulproposal1'];
        $tugasakhir->judulproposal2 = $validatedData['judulproposal2'];
        $tugasakhir->keterangan = $validatedData['keterangan'];

        // Cek apakah ada file baru yang diunggah
        if ($request->hasFile('dokumen')) {
            // Hapus file lama jika ada
            if ($tugasakhir->dokumen && Storage::exists('public/' . $tugasakhir->dokumen)) {
                Storage::delete('public/' . $tugasakhir->dokumen);
            }

            // Simpan file dokumen baru
            $dokumenPath = $request->file('dokumen')->store('dokumen_tugasakhir', 'public');
            $tugasakhir->dokumen = $dokumenPath;
        }

        // Logika perubahan status_usulan
        if (in_array($tugasakhir->status_usulan, ['2', '3'])) {
            $tugasakhir->status_usulan = '4'; // Set status menjadi "Pengajuan Kembali"
        }

        // Simpan perubahan
        if ($tugasakhir->save()) {
            return redirect()->route('tugasakhir.index')->with('success', 'Tugas Akhir berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui Tugas Akhir.');
        }
    }



    /**
     * Menghapus tugas akhir dari database.
     */
    public function destroy($id)
    {
        $tugasakhir = TugasAkhir::findOrFail($id);

        if ($tugasakhir->dokumen && Storage::exists('public/' . $tugasakhir->dokumen)) {
            Storage::delete('public/' . $tugasakhir->dokumen);
        }

        $tugasakhir->delete();

        return redirect()->route('tugasakhir.index')
            ->with('success', 'Tugas Akhir berhasil dihapus.');
    }

    /**
     * Menampilkan halaman review tugas akhir.
     */
    public function reviewview($id)
    {
        $data1 = tugasakhir::all(['id', 'judulproposal1']);
        $result1 = $this->cluster($data1);

        $data2 = tugasakhir::all(['id', 'judulproposal2']);
        $result2 = $this->cluster($data2);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('nama', $user->name)->first();
        $tugasakhir = TugasAkhir::findOrFail($id);
        $dosen = Dosen::whereHas('userdosen', function ($query) {
            $query->where('role', '!=', 'Kaprodi');
        })->get();


        return view('tugasakhir.reviewta', compact('tugasakhir', 'mahasiswa', 'dosen'));
    }

    private function cluster($proposals)
    {
        // Step 1: Preprocessing
        $documents = [];

        foreach ($proposals as $p) {
            if ($p->judulproposal1 === null) {
                $x = false;
            } else {
                $x = true;
            }
            $text = strtolower(strip_tags($p->judulproposal1 ?? $p->judulproposal2));
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
            if ($x === true) {
                foreach ($indexes as $i) {
                    tugasakhir::where('id', $documents[$i]['id'])->update([
                        'klaster' => $clusterIndex
                    ]);
                }
            } else {
                foreach ($indexes as $i) {
                    tugasakhir::where('id', $documents[$i]['id'])->update([
                        'klaster2' => $clusterIndex
                    ]);
                }
            }
        }

        $data = tugasakhir::all();
        if ($x === true) {
            $K0 = $data->where('klaster', '0');
            $K1 = $data->where('klaster', '1');
            $K2 = $data->where('klaster', '2');

            $cek = [
                'Cluster 0' => $K0->pluck('judulproposal1')->toArray(),
                'Cluster 1' => $K1->pluck('judulproposal1')->toArray(),
                'Cluster 2' => $K2->pluck('judulproposal1')->toArray(),
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
                tugasakhir::where('klaster', $clusterIndex)->update([
                    'label' => $label,
                ]);
            }
        } else {
            $K0 = $data->where('klaster2', '0');
            $K1 = $data->where('klaster2', '1');
            $K2 = $data->where('klaster2', '2');

            $cek = [
                'Cluster 0' => $K0->pluck('judulproposal2')->toArray(),
                'Cluster 1' => $K1->pluck('judulproposal2')->toArray(),
                'Cluster 2' => $K2->pluck('judulproposal2')->toArray(),
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
                tugasakhir::where('klaster2', $clusterIndex)->update([
                    'label2' => $label,
                ]);
            }
        }
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

    /**
     * Menyimpan hasil review tugas akhir.
     */
    public function reviewpost(Request $request, $id)
    {
        $tugasakhir = TugasAkhir::findOrFail($id);

        // Konversi nilai kosong menjadi null
        $request->merge([
            'pembimbing1' => $request->pembimbing1 ?: null,
            'pembimbing2' => $request->pembimbing2 ?: null,
        ]);

        $validatedData = $request->validate([
            'pilihjudul' => 'nullable|max:255',
            'pembimbing1' => 'nullable|exists:dosens,id',
            'pembimbing2' => 'nullable|exists:dosens,id',
            'reviewta' => 'nullable',
            'hasil' => 'required|in:1,2,3',
        ]);

        // Menentukan status usulan berdasarkan hasil review
        switch ($validatedData['hasil']) {
            case '1':
                $validatedData['status_usulan'] = '1'; // Diterima
                break;
            case '2':
                $validatedData['status_usulan'] = '2'; // Revisi
                break;
            case '3':
                $validatedData['status_usulan'] = '3'; // Ditolak
                break;
        }

        $tugasakhir->update($validatedData);

        return redirect()->route('tugasakhir.detail', ['id' => $tugasakhir->id])
            ->with('success', 'Review berhasil disimpan.');
    }
}
