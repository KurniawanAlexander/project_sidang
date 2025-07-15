@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        @if (session()->has('Success'))
            <div class="alert alert-success" role="alert">
                {{ session('Success') }}
            </div>
        @elseif(session()->has('Failed'))
            <div class="alert alert-danger" role="alert">
                {{ session('Failed') }}
            </div>
        @endif

        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="/sempro" class="btn btn-outline-primary">Kembali</a>
            @if ($sempro->status == 0 && Auth::user()->can('isKaprodi'))
                <a href="/semprojadwal/{{ $sempro->id }}" class="btn btn-primary ms-3">Jadwalkan</a>
            @elseif ($sempro->status == 1 && $edit === 1 && Auth::user()->can('isKaprodi'))
                <a href="/editsemprojadwal/{{ $sempro->id }}" class="btn btn-primary ms-3">Ubah Penjadwalan</a>
            @elseif ($sempro->status != 0)
                <a href="/nilaisempro/{{ $sempro->id }}" class="btn btn-primary ms-3">Nilai</a>
            @endif
        </div>

        <table class="table table-bordered table-striped">
            <thead class="text-center">
                <tr>
                    <th scope="row" colspan="2" class="bg-light">Detail Seminar Proposal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" class="bg-light">Judul Proposal</th>
                    <td>{{ $sempro->semprotugasakhir->pilihjudul }}</td>
                </tr>
                @can('isKaprodi')
                    <tr>
                        <th scope="row" class="bg-light">Validasi Pembimbing Satu</th>
                        <td>Sudah Divalidasi</td>
                    </tr>
                    <tr>
                        <th scope="row" class="bg-light">Validasi Pembimbing Dua</th>
                        <td>Sudah Divalidasi</td>
                    </tr>
                @else
                    @if ($sempro->penguji_id != Auth()->user()->userdosen->id)
                        <tr>
                            <th scope="row" class="bg-light">Validasi Pembimbing</th>
                            <td>
                                @if ($sempro->semprotugasakhir->pembimbingta1->id == Auth()->user()->userdosen->id)
                                    @if ($sempro->pembimbing1_acc === 0)
                                        <a href="/accsemprop1/{{ $sempro->id }}" class="btn btn-info btn-sm">Validasi</a>
                                    @else
                                        Sudah Divalidasi
                                    @endif
                                @elseif ($sempro->semprotugasakhir->pembimbingta2->id == Auth()->user()->userdosen->id)
                                    @if ($sempro->pembimbing2_acc === 0)
                                        <a href="/accsemprop2/{{ $sempro->id }}" class="btn btn-info btn-sm">Validasi</a>
                                    @else
                                        Sudah Divalidasi
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @endcan
                <tr>
                    <th scope="row" class="bg-light">Penguji</th>
                    <td>
                        @if ($sempro->penguji_id == 0)
                            Belum Ditentukan
                        @else
                            {{ $sempro->pengujisempro->nama_dosen }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Tanggal Sidang</th>
                    <td>
                        @if ($sempro->tgl_sempro != null)
                            {{ \Carbon\Carbon::parse($sempro->tgl_sempro)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                        @else
                            Belum Ditetapkan
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Ruangan Sidang</th>
                    <td>
                        @if ($sempro->ruangan_id != 0)
                            {{ $sempro->ruangansempro->kode_ruangan }} {{ $sempro->ruangansempro->ruangan }}
                        @else
                            Belum Ditetapkan
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light">Dokumen Proposal</th>
                    <td>
                        @if ($sempro->tugasakhir_id)
                            <a href="{{ Storage::url($sempro->semprotugasakhir->dokumen) }}"
                                class="btn btn-secondary btn-sm" target="_blank">Lihat Dokumen</a>
                        @else
                            <span>Tidak ada dokumen</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="bg-light"></th>
                    <td>
                        <a href="/downloadproposal/{{ $sempro->tugasakhir_id }}" class="btn btn-secondary btn-sm">Unduh
                            Dokumen</a>
                    </td>
                </tr>
                @if ($sempro->status == 3 || $sempro->status == 4)
                    <tr>
                        <th scope="row" class="bg-light">Nilai Sidang Proposal</th>
                        <td>{{ $sempro->nilaiakhir }}</td>
                    </tr>
                @endif
                <tr>
                    <th scope="row" class="bg-light">Status</th>
                    <td>
                        @if ($sempro->status == 0)
                            Sedang Diajukan
                        @elseif ($sempro->status == 1)
                            Sudah Dijadwalkan
                        @elseif ($sempro->status == 2)
                            Sedang Dinilai
                        @elseif ($sempro->status == 3)
                            Lulus
                        @elseif ($sempro->status == 4)
                            Tidak Lulus
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
