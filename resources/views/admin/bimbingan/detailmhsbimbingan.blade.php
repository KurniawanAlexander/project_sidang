@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <button onclick="window.history.back()" class="btn btn-outline-primary">
                Kembali
            </button>
        </div>

        @if (session()->has('Success'))
            <div class="alert alert-success" role="alert">
                {{ session('Success') }}
            </div>
        @elseif(session()->has('Failed'))
            <div class="alert alert-danger" role="alert">
                {{ session('Failed') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th colspan="2" class="bg-light">Detail Mahasiswa Bimbingan</th>
                </tr>
            </thead>
            <tbody>
                {{-- Nama Mahasiswa --}}
                <tr>
                    <th scope="row" style="width: 200px;">Nama Mahasiswa</th>
                    <td>
                        {{ $data->mahasiswa->nama ?? 'Data tidak tersedia' }}
                    </td>
                </tr>

                {{-- Judul --}}
                @if ($data->pilihjudul == '-')
                    <tr>
                        <th scope="row">Judul 1</th>
                        <td>{{ $data->judulproposal1 ?? 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Judul 2</th>
                        <td>{{ $data->judulproposal2 ?? 'Data tidak tersedia' }}</td>
                    </tr>
                @else
                    <tr>
                        <th scope="row">Judul Terpilih</th>
                        <td>{{ $data->pilihjudul }}</td>
                    </tr>
                @endif

                {{-- Pembimbing --}}
                @if ($data->pembimbing1)
                    <tr>
                        <th scope="row">Pembimbing 1</th>
                        <td>{{ $data->pembimbingta1->nama_dosen ?? 'Data tidak tersedia' }}</td>
                    </tr>
                @endif
                @if ($data->pembimbing2)
                    <tr>
                        <th scope="row">Pembimbing 2</th>
                        <td>{{ $data->pembimbingta2->nama_dosen ?? 'Data tidak tersedia' }}</td>
                    </tr>
                @endif

                {{-- Dokumen Proposal --}}
                <tr>
                    <th scope="row">Dokumen Proposal</th>
                    <td>
                        @if ($data->dokumen)
                            <a href="{{ Storage::url($data->dokumen) }}" class="btn btn-secondary btn-sm">Lihat Dokumen</a>
                        @else
                            <span>Tidak ada dokumen</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        @if ($data->dokumen)
                            <a href="/downloadproposal/{{ $data->id }}" class="btn btn-secondary btn-sm">Download
                                Dokumen</a>
                        @endif
                    </td>
                </tr>

                {{-- Acc Sidang TA --}}
                <tr>
                    <th scope="row">Verifikasi Sidang TA</th>
                    <td>
                        @php
                            $jumlahBimbingan = \App\Models\bimbingan::where('tugasakhir_id', $data->id)
                                ->where('pembimbing_id', Auth::user()->userdosen->id)
                                ->count();
                        @endphp

                        @if ($cek)
                            <a href="#" class="btn btn-info btn-sm disabled" aria-disabled="true">Sudah Verifikasi</a>
                        @else
                            @if ($jumlahBimbingan >= 9)
                                <a href="/sita/accsidangta/{{ $data->id }}" class="btn btn-info btn-sm">Verifikasi</a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Bimbingan Belum Cukup</button>
                            @endif
                        @endif
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="mt-5"></div> {{-- Jarak antara tabel mahasiswa dan pembahasan --}}

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th colspan="2" class="bg-light">Pembahasan Mahasiswa Bimbingan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="width: 200px;">Pembahasan</th>
                    <td>
                        @if ($bahas->isNotEmpty())
                            <ul style="list-style-type: none; padding: 0; margin: 0;">
                                @foreach ($bahas as $index => $item)
                                    <li style="margin-bottom: 15px;">
                                        <div><strong>Bimbingan {{ $index + 1 }}</strong></div>
                                        <div>
                                            <strong>Tanggal : {{ $item->tgl_bimbingan }}</strong>
                                        </div>
                                        <div>
                                            <strong>Status Bimbingan :
                                                @if ($item->validasi == 0)
                                                    Belum Diverifikasi
                                                @else
                                                    Sudah Diverifikasi
                                                @endif
                                            </strong>
                                        </div>
                                        <div><strong>Pembahasan :</strong>
                                            {{ $item->pembahasan ?? 'Tidak ada pembahasan' }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Belum ada pembahasan</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
