@extends('layout.template')

@section('main')
    @if (session()->has('Success'))
        <div class="alert alert-success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="text-center">
                <tr>
                    <th colspan="3" scope="row" class="bg-light">Data Pengajuan Sidang TA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" class="bg-light">Judul Proposal</th>
                    <td colspan="2">{{ $sita->sitatugasakhir->pilihjudul }}</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Nama Mahasiswa</th>
                    <td colspan="2">{{ $sita->sitatugasakhir->tugasakhirmahasiswa->nama }}</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">NIM</th>
                    <td colspan="2">{{ $sita->sitatugasakhir->tugasakhirmahasiswa->nim }}</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Pembimbing Satu</th>
                    <td colspan="2">{{ $sita->sitatugasakhir->pembimbingta1->nama_dosen }} : Sudah
                        Validasi</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Pembimbing Dua</th>
                    <td colspan="2">{{ $sita->sitatugasakhir->pembimbingta2->nama_dosen }} : Sudah
                        Validasi</td>
                </tr>
                @if ($sita->ketuasidang_id != 0)
                    <tr>
                        <th scope="row" class="bg-light">Ketua Sidang</th>
                        <td colspan="2">{{ $sita->ketuasita->nama_dosen }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Sekretaris Sidang</th>
                        <td colspan="2">{{ $sita->sekretarissita->nama_dosen }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Penguji Satu</th>
                        <td colspan="2">{{ $sita->penguji1sita->nama_dosen }}</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Penguji Dua</th>
                        <td colspan="2">{{ $sita->penguji2sita->nama_dosen }}</td>
                    </tr>
                @endif

                @if ($sita->tgl_sita != null)
                    <tr>
                        <th scope="row" class="bg-light">Tanggal Sidang</th>
                        <td colspan="2">
                            {{ \Carbon\Carbon::parse($sita->tgl_sita)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                        </td>
                    </tr>
                @endif
                @if ($sita->ruangan_id != 0)
                    <tr>
                        <th scope="row" class="bg-light">Ruangan Sidang</th>
                        <td colspan="2">
                            {{ $sita->ruangansita->kode_ruangan }} - {{ $sita->ruangansita->ruangan }}

                        </td>
                    </tr>
                @endif

                @if ($sita->status == 2)
                    <tr>
                        <th scope="row" class="bg-light">Status Validasi Dokumen</th>
                        <td colspan="2">
                            Sudah Divalidasi
                        </td>
                    </tr>
                @endif

                <tr>
                    <th scope="row" class="bg-light">Dokumen Proposal</th>
                    <td>
                        @if ($sita->tugasakhir_id)
                            <a href="{{ Storage::url($sita->sitatugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                target="_blank">Lihat Dokumen</a>
                        @else
                            <span>Tidak ada dokumen</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th scope="row" class="bg-light"></th>
                    <td colspan="2"><a href="/downloadproposal/{{ $sita->tugasakhir_id }}"
                            class="btn btn-secondary btn-sm">Unduh Dokumen</a></td>
                </tr>

                @if ($sita->status == 6 || $sita->status == 7)
                    <tr>
                        <th scope="row" class="bg-light">Nilai Sidang Proposal</th>
                        <td colspan="2">{{ $sita->nilaiakhir }}</td>
                    </tr>
                @endif
                <tr>
                    <th scope="row" class="bg-light">Status</th>
                    @if ($sita->status == 1)
                        <td>Sedang Diajukan</td>
                    @elseif($sita->status == 2)
                        <td>Sudah Divalidasi</td>
                    @elseif($sita->status == 3)
                        <td>Dijadwalkan</td>
                    @elseif($sita->status == 4)
                        <td>Sedang Sidang</td>
                    @elseif($sita->status == 5)
                        <td>Sedang Dinilai</td>
                    @elseif($sita->status == 6)
                        <td>Lulus</td>
                    @elseif($sita->status == 7)
                        <td>Tidak Lulus</td>
                    @endif
                </tr>
            </tbody>
        </table>
        @if ($sita->status == 2)
            @can('isKaprodi')
                <a href="/sitajadwal/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Jadwalkan</a>
            @endcan
        @else
            @cannot('isSuperAdmin')
                @cannot('isDosen')
                    @if ($edit === 1)
                        <a href="/editsitajadwal/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Ubah
                            Penjadwalan</a>
                    @endif
                @endcannot
            @endcannot

            @can('isSuperAdmin')
                @if ($sita->status == 1)
                    <a href="/validasidokumen/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Validasi</a>
                    <a href="/tolakvalidasidokumen/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Tolak</a>
                @endif
            @endcan
        @endif

        @cannot('isSuperAdmin')
            @if (
                $sita->sitatugasakhir->pembimbing1 == Auth::user()->userdosen->id ||
                    $sita->sitatugasakhir->pembimbing2 == Auth::user()->userdosen->id ||
                    $sita->penguji1_id == Auth::user()->userdosen->id ||
                    $sita->penguji2_id == Auth::user()->userdosen->id)
                @if ($sita->status == 6 || $sita->status == 7)
                    <a href="/nilaisita/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Lihat Nilai</a>
                @elseif(in_array($sita->status, [3, 4, 5]))
                    <a href="/nilaisita/{{ $sita->id }}" class="btn btn-primary float-end mx-1 my-3">Nilai</a>
                @endif
            @endif
        @endcannot

        <div class="mb-4 d-flex justify-content-between align-items-center my-3">
            <a href="/sita" class="btn btn-outline-primary">Kembali</a>
        </div>

    </div>
@endsection
