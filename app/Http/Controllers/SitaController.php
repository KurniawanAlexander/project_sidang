<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\sita;
use App\Models\dosen;
use App\Models\ruangan;
use App\Models\notifikasi;
use App\Models\tugasakhir;
use App\Models\pembimbingta;
use Illuminate\Http\Request;
use App\Models\bimbingan;
use App\Models\penilaiansita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SitaController extends Controller
{
    public function index()
    {

        if (Gate::allows('isMahasiswa')) {
            $cek = tugasakhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();
            if ($cek) {
                $datasita = sita::where('tugasakhir_id', $cek->id)->get();
                $sita = sita::where('tugasakhir_id', $cek->id)->orderby('updated_at', 'desc')->first();

                if (!$sita) {
                    return redirect('/dashboard')->with('Failed', 'Anda belum bisa melakukan sidang tugas akhir');
                }

                if ($sita->status == 0) {
                    return redirect('/sita/create');
                }


                $psita = penilaiansita::where('sita_id', $sita->id)->get();


                $pembimbing1 = $psita->where('jabatan', 1)->first();
                $pembimbing2 = $psita->where('jabatan', 2)->first();
                $penguji1 = $psita->where('jabatan', 3)->first();
                $penguji2 = $psita->where('jabatan', 4)->first();


                return view('admin.sita.sita', compact('sita', 'pembimbing1', 'pembimbing2', 'penguji1', 'penguji2'));
            } else {
                return redirect('/dashboard')->with('Failed', 'Mohon maaf, anda belum mengajukan data pra proposal ');
            }
        } elseif (Gate::allows('isDosen')) {
            $cek = tugasakhir::where('pembimbing1', auth::user()->userdosen->id)
                ->orWhere('pembimbing2', auth::user()->userdosen->id)
                ->get();

            $sita = sita::where(function ($query) use ($cek) {
                $query->whereIn('tugasakhir_id', $cek->pluck('id'))
                    ->orWhere('ketuasidang_id', Auth::user()->userdosen->id)
                    ->orWhere('sekretaris_id', Auth::user()->userdosen->id)
                    ->orWhere('penguji1_id', Auth::user()->userdosen->id)
                    ->orWhere('penguji2_id', Auth::user()->userdosen->id);
            })
                ->whereNot('status', 7)
                ->whereNot('ruangan_id', 0)
                ->get();

            return view('admin.sita.sita', compact('sita', 'cek'));
        } elseif (Gate::allows('isKaprodi')) {
            $sita = sita::where('pembimbing1_acc', 1)->where('pembimbing2_acc', 1)->where('status', '>', '1')->wherenot('status', 4)->get();
            return view('admin.sita.sita', compact('sita'));
        } elseif (Gate::allows('isSuperAdmin')) {
            $data = sita::all();
            return view('admin.sita.sita', compact('data'));
        }
    }
    public function create()
    {
        $cek = tugasakhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();
        if ($cek) {
            $sita = sita::where('pembimbing1_acc', 1)->where('pembimbing2_acc', 1)->where('tugasakhir_id', $cek->id)->wherenot('status', 7)->orderby('updated_at', 'desc')->first();
            if (!$sita) {
                return back()->with('Failed', 'Anda belum bisa melakukan sidang tugas akhir');
            }
        }
        return view('admin.sita.sitacreate');
    }

    public function nilaisita($id)
    {
        $sita = sita::find($id);

        $cek = tugasakhir::where('id', $sita->tugasakhir_id)->first();
        if ($cek->pembimbing1 == Auth::user()->userdosen->id) {
            $jabatan = 1;
        } elseif ($cek->pembimbing2 == Auth::user()->userdosen->id) {
            $jabatan = 2;
        } elseif ($sita->penguji1_id == Auth::user()->userdosen->id) {
            $jabatan = 3;
        } elseif ($sita->penguji2_id == Auth::user()->userdosen->id) {
            $jabatan = 4;
        } else {
            return back();
        }

        $penilaiansita = penilaiansita::where('sita_id', $id)->where('jabatan', $jabatan)->first();

        return view('admin.sita.penilaiansita', compact('penilaiansita', 'sita', 'jabatan'));
    }

    public function storenilaisita(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jabatan' => 'required',
            'id' => 'required',
            'nl_identifikasimasalah' => 'required|numeric|min:0|max:100',
            'nl_relevansiteori' => 'required|numeric|min:0|max:100',
            'nl_metodologipenelitian' => 'required|numeric|min:0|max:100',
            'nl_hasilpembahasan' => 'required|numeric|min:0|max:100',
            'nl_kesimpulansarana' => 'required|numeric|min:0|max:100',
            'nl_bahasatatatulis' => 'required|numeric|min:0|max:100',
            'nl_sikappenampilan' => 'required|numeric|min:0|max:100',
            'nl_komunikasisistematika' => 'required|numeric|min:0|max:100',
            'nl_penguasaanmateri' => 'required|numeric|min:0|max:100',
            'nl_kesesuaianfungsi' => 'required|numeric|min:0|max:100',
            'totalnilai' => 'required|numeric|min:0|max:100',
            'komentar' => 'nullable|string|max:1000'
        ]);

        if ($validatedData['id'] == 0) {
            $tambahdata = penilaiansita::create([
                'sita_id' => $id,
                'jabatan' => $validatedData['jabatan'],
                'nl_identifikasimasalah' => $validatedData['nl_identifikasimasalah'],
                'nl_relevansiteori' => $validatedData['nl_relevansiteori'],
                'nl_metodologipenelitian' => $validatedData['nl_metodologipenelitian'],
                'nl_hasilpembahasan' => $validatedData['nl_hasilpembahasan'],
                'nl_kesimpulansarana' => $validatedData['nl_kesimpulansarana'],
                'nl_bahasatatatulis' => $validatedData['nl_bahasatatatulis'],
                'nl_sikappenampilan' => $validatedData['nl_sikappenampilan'],
                'nl_komunikasisistematika' => $validatedData['nl_komunikasisistematika'],
                'nl_penguasaanmateri' => $validatedData['nl_penguasaanmateri'],
                'nl_kesesuaianfungsi' => $validatedData['nl_kesesuaianfungsi'],
                'totalnilai' => $validatedData['totalnilai'],
                'komentar' => $validatedData['komentar']
            ]);
        } else {
            $data = penilaiansita::find($validatedData['id']);
            $tambahdata = $data->update($validatedData);
        }

        $sita = sita::find($id);
        $psita = penilaiansita::where('sita_id', $id)->get();

        if ($psita->count() >= 1 && $psita->count() < 4) {
            $sita->update(['status' => 5]);
        }

        if ($psita->count() == 4) {
            $nilaipembimbing1 = $psita->where('jabatan', 1)->first();
            $nilaipembimbing2 = $psita->where('jabatan', 2)->first();
            $nilaipenguji1 = $psita->where('jabatan', 3)->first();
            $nilaipenguji2 = $psita->where('jabatan', 4)->first();



            $nilaiakhir = ($nilaipembimbing1->totalnilai + $nilaipembimbing2->totalnilai + $nilaipenguji1->totalnilai + $nilaipenguji2->totalnilai) / 4;

            if ($nilaiakhir > 70) {
                $sita->update([
                    'nilaiakhir' => $nilaiakhir,
                    'status' => 6
                ]);
            } else {
                $sita->update([
                    'nilaiakhir' => $nilaiakhir,
                    'status' => 7
                ]);
            }
        }

        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, anda gagal menyimpan nilai');
        }

        return back()->with('Success', 'Nilai Berhasil Disimpan');
    }

    public function store(request $request)
    {
        $validatedData = $request->validate([
            'dokumen' => 'required|mimes:pdf'
        ]);
        $cek = tugasakhir::where('mahasiswa_id', Auth::user()->usermahasiswa->id)->first();
        $sita = sita::where('tugasakhir_id', $cek->id)->orderby('updated_at', 'desc')->first();

        // if ($request->hasFile('dokumen')) {
        //     $ceksimilaritydatabase = SimilarityController::ceksimilarityta($validatedData['dokumen']);
        //     $ceksimilarityscholar = SimilarityController::ceksimilarityscholar($cek->judulterpilih, $validatedData['dokumen']);
        //     if (!$ceksimilaritydatabase || !$ceksimilarityscholar) {
        //         return back()->with('Failed', 'Mohon maaf, laporan anda terlalu mirip dengan laporan yang sudah ada');
        //     }
        // }

        $tambahdatasita = $sita->update([
            'status' => 1,
        ]);

        if (!$tambahdatasita) {
            return back()->with('Failed', 'Mohon maaf, data gagal diajukan');
        }

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $extension = $file->getClientOriginalExtension();
            $namaFileBaru = $cek->judulterpilih . '.' . $extension;
            $path = $file->storeAs('dokumen_tugasakhir', $namaFileBaru, 'public');
            $validatedData['dokumen'] = $path;
        } else {
            $validatedData['dokumen'] = '-';
        }

        $cek->update(['dokumen' => $validatedData['dokumen']]);

        return redirect('/sita')->with('Success', 'Pengajuan Sidang anda berhasil diajukan');
    }

    public function formsitajadwal($id)
    {
        $sita = sita::findOrFail($id);
        $dosen = dosen::all();
        $ruangan = ruangan::all();

        return view('admin.sita.formjadwalsita', compact('sita', 'dosen', 'ruangan'));
    }

    public function storesitajadwal(request $request, $id)
    {
        $sita = sita::find($id);
        $validatedData = $request->validate([
            'ketuasidang_id' => 'required',
            'sekretaris_id' => 'required',
            'penguji1_id' => 'required',
            'penguji2_id' => 'required',
            'tgl_sita' => 'required',
            'ruangan_id' => 'required'
        ]);

        $validatedData['status'] = 3;
        $tambahdata = $sita->update($validatedData);

        if (!$tambahdata) {
            return back()->with('Failed', 'Mohon maaf, sidang seminar proposal gagal dijadwalkan');
        }

        // NotifikasiController::createnotifikasi($sita->ketuasita->user_id, 'Pemberitahuan', 'Anda Ditugaskan Sebagai Ketua di Sidang Tugas Akhir. Silahkan Cek menu sidang tugas akhir untuk info lebih lanjut');
        // NotifikasiController::createnotifikasi($sita->sekretarissita->user_id, 'Pemberitahuan', 'Anda Ditugaskan Sebagai Sekretaris di Sidang Tugas Akhir. Silahkan Cek menu sidang tugas akhir untuk info lebih lanjut');
        // NotifikasiController::createnotifikasi($sita->penguji1sita->user_id, 'Pemberitahuan', 'Anda Ditugaskan Sebagai Penguji di Sidang Tugas Akhir. Silahkan Cek menu sidang tugas akhir untuk info lebih lanjut');
        // NotifikasiController::createnotifikasi($sita->penguji2sita->user_id, 'Pemberitahuan', 'Anda Ditugaskan Sebagai Penguji di Sidang Tugas Akhir. Silahkan Cek menu sidang tugas akhir untuk info lebih lanjut');
        // NotifikasiController::createnotifikasi($sita->sitatugasakhir->datapembimbingta->pembimbing2->user_id, 'Pemberitahuan', 'Mahasiswa bimbingan anda akan melakukan sidang tugas akhir. Silahkan Cek menu sidang tugas akhir untuk info lebih lanjut');
        // NotifikasiController::createnotifikasi($sita->sitatugasakhir->mahasiswatugasakhir->user_id, 'Pemberitahuan', 'Pengajuan sidang tugas akhir anda telah dijadwalkan, silahkan lihat data pengajuan untuk lebih detail');

        return redirect('/detailsita/' . $id)->with('Success', 'Penjadwalan sidang proposal berhasil dijadwalkan');
    }

    public function download($id)
    {
        $data = tugasakhir::find($id);

        return response()->download(storage_path('app/public/' . $data->dokumen));
    }

    public function accsidangta($id)
    {
        $bimbingan = bimbingan::where('tugasakhir_id', $id)->where('pembimbing_id', Auth::user()->userdosen->id)->get();
        if ($bimbingan->count() < 9) {
            return back()->with('Failed', 'Mohon maaf, mahasiswa ini belum memenuhi batas minimal bimbingan');
        }
        $ta = tugasakhir::find($id);

        $pembimbingta = tugasakhir::where('id', $ta->id)->first();
        if ($pembimbingta->pembimbing1 == Auth::User()->userdosen->id) {
            $pembimbingta = 1;
        } elseif ($pembimbingta->pembimbing2 == Auth::User()->userdosen->id) {
            $pembimbingta = 2;
        } else {
            return back()->with('Failed', 'Mohon maaf ada kesalahan pada sistem kami');
        }

        $cek = sita::where('tugasakhir_id', $ta->id)->wherenot('status', 7)->orderby('updated_at', 'desc')->first();
        if (!$cek) {
            if ($pembimbingta == 1) {
                $tambahdatasita = sita::create([
                    'tugasakhir_id' => $ta->id,
                    'pembimbing1_acc' => 1
                ]);
            } else {
                $tambahdatasita = sita::create([
                    'tugasakhir_id' => $ta->id,
                    'pembimbing2_acc' => 1
                ]);
            }
        } else {
            if ($pembimbingta == 1) {
                $tambahdatasita = $cek->update([
                    'pembimbing1_acc' => 1
                ]);
            } else {
                $tambahdatasita = $cek->update([
                    'pembimbing2_acc' => 1
                ]);
            }
        }
        if (!$tambahdatasita) {
            return back()->with('Failed', 'Mohon maaf, ada kesalahan pada sistem kami');
        }

        return back()->with('Success', 'Data berhasil di verifikasi');
    }

    public function detail($id)
    {
        $sita = sita::find($id);

        if (Carbon::now('Asia/Jakarta')->diffInDays($sita->tgl_sita) < 1) {
            $edit = 0;
        } else {
            $edit = 1;
        }


        return view('admin.sita.sitadetail', compact('sita', 'edit'));
    }

    public function validasidokumen($id)
    {
        $sita = sita::find($id);

        $validasi = $sita->update(['status' => 2]);
        if (!$validasi) {
            return back()->with('Failed', 'Dokumen gagal di validasi');
        }


        return back()->with('Success', 'Dokumen sukses di validasi');
    }

    public function tolakvalidasidokumen($id)
    {
        $sita = sita::find($id);


        $validasi = $sita->update(['deleted' => 1]);

        // notifikasi::create([
        //     'user_id' => $sita->sitatugasakhir->mahasiswatugasakhir->user_id,
        //     'judul' => 'Pemberitahuan',
        //     'notifikasi' => 'Pengajuan sidang tugas akhir anda ditolak, silahkan lengkapi dokumen anda dan ajukan kembali'
        // ]);


        if (!$validasi) {
            return back()->with('Failed', 'Pengajuan Sidang Ta gagal di tolak');
        }

        return redirect('/sita')->with('Success', 'Pengajuan Sidang Ta sukses di tolak');
    }
}
