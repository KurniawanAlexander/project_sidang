<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\dosen;
use App\Models\sempro;
use App\Models\ruangan;
use App\Models\tugasakhir;
use App\Models\penilaiansempro;
use App\Models\penilaian_sita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SemproController extends Controller
{
    public function index()
    {
        if (Gate::allows('isMahasiswa')) {
            $cek = tugasakhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();
            if ($cek) {
                $sempro = sempro::where('tugasakhir_id', $cek->id)->orderby('updated_at', 'desc')->first();
                if (!$sempro) {
                    return redirect('/sempro/create');
                }
                $psempro = penilaiansempro::where('sempro_id', $sempro->id)->get();


                $pembimbing1 = $psempro->where('jabatan', 1)->first();
                $pembimbing2 = $psempro->where('jabatan', 2)->first();
                $penguji = $psempro->where('jabatan', 3)->first();


                return view('admin.sempro.sempro', compact('sempro', 'pembimbing1', 'pembimbing2', 'penguji'));
            } else {
                return redirect('/dashboard')->with('Failed', 'Mohon maaf, anda belum mengajukan data pra proposal ');
            }
        } elseif (Gate::allows('isDosen')) {
            $cek = tugasakhir::where('pembimbing1', auth::user()->userdosen->id)
                ->orWhere('pembimbing2', auth::user()->userdosen->id)
                ->get();


            if ($cek) {
                $sempro = sempro::whereIn('tugasakhir_id', $cek->pluck('id'))
                    ->where('status', '!=', 4)
                    ->orWhere('penguji_id', auth::user()->userdosen->id)
                    ->get();
                return view('admin.sempro.sempro', compact('sempro'));
            }
        } elseif (Gate::allows('isKaprodi')) {
            $sempro = sempro::where('pembimbing1_acc', 1)->where('pembimbing2_acc', 1)->wherenot('status', 4)->get();
            return view('admin.sempro.sempro', compact('sempro'));
        }
    }

    public function formsemprojadwal($id)
    {
        $sempro = sempro::findOrFail($id);
        $user = Auth::user();
        $dosen = dosen::all();
        $ruangan = ruangan::all();

        return view('admin.sempro.formjadwalsempro', compact('id', 'dosen', 'ruangan'));
    }

    public function formeditsemprojadwal($id)
    {
        $sempro = sempro::findOrFail($id);
        $user = Auth::user();
        $dosen = dosen::all();
        $ruangan = ruangan::all();

        return view('admin.sempro.formeditjadwalsempro', compact('sempro', 'dosen', 'ruangan'));
    }

    public function storesemprojadwal(request $request, $id)
    {
        $sempro = sempro::find($id);
        $validatedData = $request->validate([
            'penguji_id' => 'required',
            'tgl_sempro' => 'required',
            'ruangan_id' => 'required'
        ]);
        $validatedData['status'] = 1;
        $tambahdata = $sempro->update($validatedData);

        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, sidang seminar proposal gagal dijadwalkan');
        }

        return redirect('/detailsempro/' . $id)->with('Success', 'Penjadwalan sidang proposal berhasil dijadwalkan');
    }

    public function updatesemprojadwal(request $request, $id)
    {
        $sempro = sempro::find($id);

        $validatedData = $request->validate([
            'penguji_id' => 'required',
            'tgl_sempro' => 'required',
            'ruangan_id' => 'required'
        ]);

        $tambahdata = $sempro->update($validatedData);

        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, sidang seminar proposal gagal dijadwalkan');
        }

        return redirect('/detailsempro/' . $id)->with('Success', 'Data penjadwalan sidang proposal berhasil diubah');
    }

    public function accsemprop1($id)
    {
        $sempro = sempro::find($id);

        $validasi = $sempro->update(['pembimbing1_acc' => 1]);

        if (!$validasi) {
            return back()->with('Failed', 'Mohon maaf, anda gagal melakukan validasi seminar proposal');
        }

        return back()->with('Success', 'Validasi Seminar Proposal berhasil dilakukan');
    }

    public function accsemprop2($id)
    {
        $sempro = sempro::find($id);

        $validasi = $sempro->update(['pembimbing2_acc' => 1]);

        if (!$validasi) {
            return back()->with('Failed', 'Mohon maaf, anda gagal melakukan validasi seminar proposal');
        }

        return back()->with('Success', 'Validasi Seminar Proposal berhasil dilakukan');
    }

    public function detail($id)
    {
        $sempro = sempro::find($id);

        if (Carbon::now('Asia/Jakarta')->diffInDays($sempro->tgl_sempro) < 1) {
            $edit = 0;
        } else {
            $edit = 1;
        }

        return view('admin.sempro.semprodetail', compact('sempro', 'edit'));
    }

    public function nilaisempro($id)
    {
        $sempro = sempro::find($id);

        $cek = tugasakhir::where('id', $sempro->tugasakhir_id)->first();
        if ($cek->pembimbing1 == Auth::user()->userdosen->id) {
            $jabatan = 1;
        } elseif ($cek->pembimbing2 == Auth::user()->userdosen->id) {
            $jabatan = 2;
        } elseif ($sempro->penguji_id == Auth::user()->userdosen->id) {
            $jabatan = 3;
        } else {
            return back();
        }

        $penilaiansempro = penilaiansempro::where('sempro_id', $id)->where('jabatan', $jabatan)->first();

        return view('admin.sempro.penilaiansempro', compact('penilaiansempro', 'sempro', 'jabatan'));
    }

    public function storenilaisempro(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required',
            'id' => 'required',
            'nl_pendahuluan' => 'required|numeric|min:0|max:100',
            'nl_tinjauanpustaka' => 'required|numeric|min:0|max:100',
            'nl_metodologipenelitian' => 'required|numeric|min:0|max:100',
            'nl_bahasadantatatulis' => 'required|numeric|min:0|max:100',
            'nl_presentasi' => 'required|numeric|min:0|max:100',
            'ratarata' => 'required|numeric|min:0|max:100',
            'komentar' => 'nullable|string|max:1000'
        ]);

        if ($validatedData['id'] == 0) {
            $tambahdata = penilaiansempro::create([
                'sempro_id' => $id,
                'jabatan' => $validatedData['jabatan'],
                'nl_pendahuluan' => $validatedData['nl_pendahuluan'],
                'nl_tinjauanpustaka' => $validatedData['nl_tinjauanpustaka'],
                'nl_metodologipenelitian' => $validatedData['nl_metodologipenelitian'],
                'nl_bahasadantatatulis' => $validatedData['nl_bahasadantatatulis'],
                'nl_presentasi' => $validatedData['nl_presentasi'],
                'ratarata' => $validatedData['ratarata'],
                'komentar' => $validatedData['komentar']
            ]);
        } else {
            $data = penilaiansempro::find($validatedData['id']);
            $tambahdata = $data->update($validatedData);
        }

        $sempro = sempro::find($id);
        $psempro = penilaiansempro::where('sempro_id', $id)->get();

        if ($psempro->count() >= 1 && $psempro->count() < 3) {
            $sempro->update(['status' => 2]);
        }

        if ($psempro->count() == 3) {
            $nilaipembimbing1 = $psempro->where('jabatan', 1)->first();
            $nilaipembimbing2 = $psempro->where('jabatan', 2)->first();
            $nilaipenguji = $psempro->where('jabatan', 3)->first();

            $rataratanilaipembimbing = (
                (
                    ($nilaipembimbing1->nl_pendahuluan ?? 0) +
                    ($nilaipembimbing1->nl_tinjauanpustaka ?? 0) +
                    ($nilaipembimbing1->nl_metodologipenelitian ?? 0) +
                    ($nilaipembimbing1->nl_bahasadantatatulis ?? 0) +
                    ($nilaipembimbing1->nl_presentasi ?? 0) +
                    ($nilaipembimbing2->nl_pendahuluan ?? 0) +
                    ($nilaipembimbing2->nl_tinjauanpustaka ?? 0) +
                    ($nilaipembimbing2->nl_metodologipenelitian ?? 0) +
                    ($nilaipembimbing2->nl_bahasadantatatulis ?? 0) +
                    ($nilaipembimbing2->nl_presentasi ?? 0)
                ) / 10
            ) * 0.6;

            $rataratanilaipenguji = (
                (
                    ($nilaipenguji->nl_pendahuluan ?? 0) +
                    ($nilaipenguji->nl_tinjauanpustaka ?? 0) +
                    ($nilaipenguji->nl_metodologipenelitian ?? 0) +
                    ($nilaipenguji->nl_bahasadantatatulis ?? 0) +
                    ($nilaipenguji->nl_presentasi ?? 0)

                ) / 5
            ) * 0.4;

            $nilaiakhir = $rataratanilaipembimbing + $rataratanilaipenguji;

            if ($nilaiakhir > 70) {
                $sempro->update([
                    'nilaiakhir' => $nilaiakhir,
                    'status' => 3
                ]);
            } else {
                $sempro->update([
                    'nilaiakhir' => $nilaiakhir,
                    'status' => 4
                ]);
            }
        }

        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, anda gagal menyimpan nilai');
        }

        return back()->with('Success', 'Nilai Berhasil Disimpan');
    }

    public function updateRataRata(Request $request)
    {
        $validated = $request->validate([
            'rata_rata' => 'required|numeric|min:0|max:100',
        ]);

        // Simpan nilai rata-rata ke database
        $penilaian = penilaiansempro::where('id', auth::user())->first(); // Atur query sesuai kebutuhan
        if ($penilaian) {
            $penilaian->rata_rata = $validated['rata_rata'];
            $penilaian->save();
            return response()->json(['message' => 'Nilai rata-rata berhasil diperbarui'], 200);
        }

        return response()->json(['message' => 'Data penilaian tidak ditemukan'], 404);
    }


    public function create()
    {
        return view('admin.sempro.semprocreate');
    }

    public function store(request $request)
    {
        $validatedData = $request->validate([
            'dokumen' => 'required|mimes:pdf'
        ]);

        $cek = tugasakhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();

        $tambahdatasempro = sempro::create([
            'tugasakhir_id' => $cek->id,
        ]);

        if (!$tambahdatasempro) {
            return back()->with('Failed', 'Mohon maaf, data gagal diajukan');
        }

        if ($request->hasFile('dokumen')) {

            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $cek->pilihjudul . '.' . $extension;
            $path = $file->storeAs('dokumen_tugasakhir', $namaFileBaru, 'public');
            $validatedData['dokumen'] = $path;
        } else {
            $validatedData['dokumen'] = '-';
        }

        $cek->update(['dokumen' => $validatedData['dokumen']]);

        return redirect('/sempro')->with('Success', 'Proposal anda berhasil diajukan');
    }

    public function edit(sempro $sempro)
    {
        return view('admin.sempro.semproedit', compact('sempro'));
    }

    public function update(request $request, sempro $sempro)
    {
        $cek = tugasakhir::find($sempro->tugasakhir_id);

        $validatedData = $request->validate([
            'dokumen' => 'required|mimes:pdf'
        ]);

        if ($request->hasFile('dokumen')) {

            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $cek->judulterpilih . '.' . $extension;
            $path = $file->storeAs('proposalta', $namaFileBaru, 'public');
            $validatedData['dokumen'] = $path;
        } else {
            $validatedData['dokumen'] = '-';
        }

        $ubahpengajuan = $cek->update(['dokumen' => $validatedData['dokumen']]);

        if (!$ubahpengajuan) {
            return back()->with('Failed', 'Mohon maaf, perubahan data pengajuan gagal dilakukan');
        }

        return redirect('/sempro')->with('Success', 'Perubahan data pengajuan berhasil dilakukan');
    }
}
