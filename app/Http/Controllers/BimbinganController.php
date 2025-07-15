<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\sita;
use App\Models\dosen;
use App\Models\mahasiswa;
use App\Models\bimbingan;
use App\Models\tugasakhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BimbinganController extends Controller
{
    public function index()
    {
        if (Gate::allows('isDosen')) {
            $userdosen = Auth::user();

            if (!$userdosen) {
                return redirect('/dashboard')->with('error', 'Data dosen tidak ditemukan.');
            }

            $cek = dosen::where('user_id', $userdosen->id)->first();

            $data = tugasakhir::where('pembimbing1', $cek->id)->orwhere('pembimbing2', $cek->id)->paginate(5);

            return view('admin.bimbingan.mhsbimbingan', compact('data'));
        }

        if (Gate::allows('isMahasiswa')) {


            $cek = mahasiswa::where('user_id', Auth::user()->id)->first();

            $cek = tugasakhir::where('mahasiswa_id', $cek->id)->first();

            $data = bimbingan::where('tugasakhir_id', $cek->id)->paginate(10);

            if (!$cek) {
                return redirect('/dashboard')->with('error', 'Data tugas akhir tidak ditemukan.');
            }

            return view('admin.bimbingan.kartubimbingan', compact('data'));
        }

        if (Gate::allows('isKetuaprodi')) {
            $data = tugasakhir::where('deleted', 0)->get();

            return view('admin.bimbingan.mhsbimbingan', compact('data'));
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
    }

    public function download($id)
    {
        $data = TugasAkhir::findOrFail($id);
        $filePath = storage_path('app/public/' . $data->dokumen);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    public function detail($id)
    {
        // Pastikan user yang login adalah dosen
        $userDosen = Auth::user()->userdosen;

        if (!$userDosen) {
            return redirect()->back()->with('error', 'Anda bukan dosen yang valid.');
        }

        // Ambil data tugas akhir berdasarkan ID
        $data = tugasakhir::findOrFail($id);
        $cek = sita::where('tugasakhir_id', $id)->wherenot('status', 7)->get();

        if ($data->pembimbing1 == $userDosen->id) {
            $cek = $cek->where('pembimbing1_acc', 1)->first();
        } elseif ($data->pembimbing2 == $userDosen->id) {
            $cek = $cek->where('pembimbing2_acc', 1)->first();
        } else {
            return back()->with('Failed', 'Mohon maaf ada kesalahan pada sistem kami');
        }

        // Cek apakah dosen ini adalah pembimbing dari tugas akhir
        $data = tugasakhir::where(function ($query) use ($userDosen) {
            $query->where('pembimbing1', $userDosen->id)
                ->orWhere('pembimbing2', $userDosen->id);
        })->first();

        // Ambil data bimbingan berdasarkan tugas akhir dan pembimbing yang login
        $bahas = bimbingan::where('tugasakhir_id', $id)
            ->where('pembimbing_id', $userDosen->id)
            ->get();

        // Return ke view dengan data yang sesuai
        return view('admin.bimbingan.detailmhsbimbingan', compact('data', 'data', 'bahas', 'cek'));
    }


    // public function datadetail($id)
    // {
    //     $bahas = bimbingan::findOrFail($id);

    //     return view('admin.bimbingan.detailmhsbimbingan', compact('bahas'));
    // }

    public function kartubimbingan($id, Request $request)
    {
        $search = $request->input('search');

        if (Gate::allows('isMahasiswa')) {

            $tugasakhir = TugasAkhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();

            if (!$tugasakhir) {
                return redirect('/dashboard')->with('error', 'Data tugas akhir tidak ditemukan.');
            }

            $search = $request->input('search');
            $data = Bimbingan::where('tugasakhir_id', $tugasakhir->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('pembahasan', 'like', '%' . $search . '%');
                })
                ->paginate(10);

            return view('admin.bimbingan.kartubimbingan', compact('data', 'tugasakhir'));
        }

        if (Gate::allows('isDosen')) {
            $cek = tugasakhir::where('pembimbing1', Auth::user()->userdosen->id)
                ->orWhere('pembimbing2', Auth::user()->userdosen->id)
                ->first();

            if (!$cek) {
                return redirect('/dashboard')->with('error', 'Data tugas akhir tidak ditemukan.');
            }

            $search = $request->input('search');
            $data = bimbingan::where('pembimbing_id', Auth::user()->userdosen->id)
                ->when($search, function ($query) use ($search) {
                    $query->where('pembahasan', 'like', '%' . $search . '%');
                })
                ->paginate(10);

            return view('admin.bimbingan.kartubimbingan', compact('data', 'cek'));
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
    }

    public function create()
    {
        $tugasAkhir = TugasAkhir::all();
        // $userDosen = Auth::user()->userdosen;
        $usermahasiswa = Auth::user()->usermahasiswa;

        // if (!$userDosen) {
        //     return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        // }

        if (!$usermahasiswa) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }

        // Cari data tugas akhir sesuai dengan dosen yang sedang login
        // $tugasAkhir = TugasAkhir::where('pembimbing1', $userDosen->id)
        //     ->orWhere('pembimbing2', $userDosen->id)
        //     ->first();

        $tugasakhir = TugasAkhir::where('mahasiswa_id', $usermahasiswa->id)->first();

        if (!$tugasakhir) {
            return redirect()->back()->with('error', 'Tugas Akhir tidak ditemukan.');
        }

        // Kirim data ke view
        return view('admin.bimbingan.create', compact('tugasakhir'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tugasakhir_id' => 'required|exists:tugasakhirs,id', // Validasi tugas akhir ID
            'pembimbing_id' => 'required',
            'pembahasan' => 'required|max:255',
        ]);

        $usermahasiswa = Auth::user()->usermahasiswa;
        if (!$usermahasiswa) {
            return back()->with('Failed', 'Data mahasiswa tidak ditemukan. Harap periksa akun Anda.');
        }

        $validatedData['validasi'] = 0;
        $validatedData['mahasiswa_id'] = $usermahasiswa->id;
        $validatedData['tgl_bimbingan'] = Carbon::now('Asia/Jakarta');

        $tambahdata = Bimbingan::create($validatedData);

        if (!$tambahdata) {
            return back()->with('Failed', 'Gagal Mengisi Bimbingan');
        }


        return redirect('/kartubimbingan/' . $validatedData['tugasakhir_id'])
            ->with('Success', 'Bimbingan Berhasil Diisi');
    }

    public function verifikasibimbingan($id)
    {
        $cek = Bimbingan::find($id);

        $cek->update(['validasi' => 1]);

        return back()->with('Success', 'Bimbingan berhasil di verfikasi');
    }

    public function edit($id)
    {
        // Cari data bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($id);

        // Ambil data tugasakhir yang terkait dengan bimbingan ini
        $tugasakhir = TugasAkhir::findOrFail($bimbingan->tugasakhir_id);

        // Periksa apakah mahasiswa yang login memiliki tugasakhir tersebut
        $usermahasiswa = Auth::user()->usermahasiswa;
        if (!$usermahasiswa || $usermahasiswa->id !== $tugasakhir->mahasiswa_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit bimbingan ini.');
        }

        // Kirim data bimbingan dan tugasakhir ke view
        return view('admin.bimbingan.edit', compact('bimbingan', 'tugasakhir'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'pembimbing_id' => 'required',
            'pembahasan' => 'required|string|max:255',
        ]);

        // Temukan data bimbingan yang akan diupdate
        $bimbingan = Bimbingan::findOrFail($id);

        // Ambil data tugasakhir yang terkait dengan bimbingan ini
        $tugasakhir = TugasAkhir::findOrFail($bimbingan->tugasakhir_id);

        // Periksa apakah mahasiswa yang login memiliki tugasakhir tersebut
        $usermahasiswa = Auth::user()->usermahasiswa;
        if (!$usermahasiswa || $usermahasiswa->id !== $tugasakhir->mahasiswa_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit bimbingan ini.');
        }

        // Update data bimbingan
        $bimbingan->update([
            'pembimbing_id' => $validatedData['pembimbing_id'],
            'pembahasan' => $validatedData['pembahasan'],
            'tgl_bimbingan' => Carbon::now('Asia/Jakarta'),
        ]);

        // Redirect ke halaman detail tugas akhir setelah berhasil update
        return redirect('/kartubimbingan/' . $tugasakhir->id)
            ->with('Success', 'Data bimbingan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        // Temukan data bimbingan berdasarkan ID
        $bimbingan = Bimbingan::findOrFail($id);

        // Simpan tugasakhir_id untuk redirect
        $tugasakhir_id = $bimbingan->tugasakhir_id;

        // Hapus data bimbingan
        $bimbingan->delete();

        return redirect('/kartubimbingan/' . $bimbingan['tugasakhir_id'])
            ->with('Success', 'Data bimbingan berhasil dihapus.');
    }
}
