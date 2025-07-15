@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        @if (Auth::user()->can('isMahasiswa'))
            @if ($tugasakhir->status_usulan == '0')
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                        Kembali
                    </a>
                    <a href="{{ route('tugasakhir.edit', $tugasakhir->id) }}" class="btn btn-primary ms-3">
                        <i class="fas fa-edit"></i> Edit Pengajuan Proposal
                    </a>
                </div>
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 200px;">Detail</th>
                            {{-- <td><a href="/tugasakhir/{{ $tugasakhir->id }}/edit">Ubah Pengajuan Proposal</a></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 200px;">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul 1</th>
                            <td>{{ $tugasakhir->judulproposal1 ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul 2</th>
                            <td>{{ $tugasakhir->judulproposal2 ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @elseif ($tugasakhir->status_usulan == '1')
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                        Kembali
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" colspan="2" style="width: 200px;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{ $tugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 1</th>
                            <td>{{ $tugasakhir->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }} | Bidang Keahlian : {{ $tugasakhir->pembimbingta1->bidangkeahliandosen->bidangkeahlian}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 2</th>
                            <td>{{ $tugasakhir->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }} | Bidang Keahlian : {{ $tugasakhir->pembimbingta2->bidangkeahliandosen->bidangkeahlian}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan dari Mahasiswa</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>{{ $tugasakhir->reviewta ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @elseif ($tugasakhir->status_usulan == '2')
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                        Kembali
                    </a>
                    <a href="{{ route('tugasakhir.edit', $tugasakhir->id) }}" class="btn btn-primary ms-3">
                        <i class="fas fa-edit"></i> Edit Pengajuan Proposal
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 250px;">Detail</th>
                            {{-- <td><a href="/admin/tugasakhir/{{ $tugasakhir->id }}/edit">Ubah Pengajuan Proposal</a></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{ $tugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 1</th>
                            <td>{{ $tugasakhir->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 2</th>
                            <td>{{ $tugasakhir->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan dari Mahasiswa</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>{{ $tugasakhir->reviewta ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @elseif ($tugasakhir->status_usulan == '3')
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                        Kembali
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 250px;">Detail</th>
                            {{-- <td><a href="/admin/tugasakhir/{{ $tugasakhir->id }}/edit">Ubah Pengajuan Proposal</a></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{ $tugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 1</th>
                            <td>{{ $tugasakhir->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 2</th>
                            <td>{{ $tugasakhir->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan dari Mahasiswa</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>{{ $tugasakhir->reviewta ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @elseif ($tugasakhir->status_usulan == '4')
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                        Kembali
                    </a>
                    <a href="{{ route('tugasakhir.edit', $tugasakhir->id) }}" class="btn btn-primary ms-3">
                        <i class="fas fa-edit"></i> Edit Pengajuan Proposal
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 250px;">Detail</th>
                            {{-- <td><a href="/admin/tugasakhir/{{ $tugasakhir->id }}/edit">Ubah Pengajuan Proposal</a></td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{ $tugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 1</th>
                            <td>{{ $tugasakhir->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 2</th>
                            <td>{{ $tugasakhir->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan dari Mahasiswa</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>{{ $tugasakhir->reviewta ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Pengajuan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @elseif (Auth::user()->can('isKaprodi'))
            <div class="mb-4">
                <a href="{{ route('tugasakhir.index') }}" class="btn btn-outline-primary">
                    Kembali
                </a>
            </div>
            @if ($tugasakhir->status_usulan == '0')
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 200px;">Detail</th>
                            <td><a href="/tugasakhir/reviewta/{{ $tugasakhir->id }}" class="btn btn-info btn-sm">Review
                                    Proposal</a></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul 1</th>
                            <td>{{ $tugasakhir->judulproposal1 ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul 2</th>
                            <td>{{ $tugasakhir->judulproposal2 ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th scope="row" style="width: 200px;">Detail</th>
                            <td><a href="{{ route('tugasakhir.reviewta', ['id' => $tugasakhir->id]) }}">Review
                                    Proposal</a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $tugasakhir->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Judul</th>
                            <td>{{ $tugasakhir->pilihjudul ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 1</th>
                            <td>{{ $tugasakhir->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }} | Bidang Keahlian : {{ $tugasakhir->pembimbingta1->bidangkeahliandosen->bidangkeahlian}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Pembimbing 2</th>
                            <td>{{ $tugasakhir->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }} | Bidang Keahlian : {{ $tugasakhir->pembimbingta1->bidangkeahliandosen->bidangkeahlian}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Dokumen Proposal</th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                        {{-- target="_blank" --}}>Lihat Dokumen</a>
                                @else
                                    <span>Tidak ada dokumen</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"></th>
                            <td>
                                @if ($tugasakhir->dokumen)
                                    <a href="/downloadproposal/{{ $tugasakhir->id }}"class="btn btn-secondary btn-sm">Download
                                        Dokumen</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan dari Mahasiswa</th>
                            <td>{{ $tugasakhir->keterangan ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td>{{ $tugasakhir->reviewta ?? 'Data tidak tersedia' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status Usulan</th>
                            <td>
                                @if ($tugasakhir->status_usulan == '0')
                                    <span>Pengajuan</span>
                                @elseif ($tugasakhir->status_usulan == '1')
                                    <span>Diterima</span>
                                @elseif ($tugasakhir->status_usulan == '2')
                                    <span>Revisi</span>
                                @elseif ($tugasakhir->status_usulan == '3')
                                    <span>Ditolak</span>
                                @elseif ($tugasakhir->status_usulan == '4')
                                    <span>Diajukan Kembali</span>
                                @else
                                    <span>Data tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endif
    </div>
@endsection
