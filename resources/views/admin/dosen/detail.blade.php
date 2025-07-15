@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('dosen.index') }}" class="btn btn-outline-primary">
                Kembali
            </a>
            <h2 class="mb-0 text-center flex-grow-1">Detail Dosen</h2>
            <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-primary ms-3">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>

        @if ($dosen)
            <div class="card shadow-sm p-4">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            @if ($dosen->foto == '-')
                                <div class="border p-4 bg-light text-muted">Foto tidak tersedia</div>
                            @else
                                <img src="{{ asset('storage/' . $dosen->foto) }}?{{ time() }}" alt="Foto Dosen"
                                    class="img-fluid rounded" style="max-width: 100%; height: auto;">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="bg-light" style="width: 150px;">Nama Dosen</th>
                                    <td>{{ $dosen->nama_dosen ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">NIP</th>
                                    <td>{{ $dosen->nip ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">NIDN</th>
                                    <td>{{ $dosen->nidn ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Gender</th>
                                    <td>
                                        @if ($dosen->gender === 'Laki-laki')
                                            Laki-laki
                                        @elseif ($dosen->gender === 'Perempuan')
                                            Perempuan
                                        @else
                                            Data tidak tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Jurusan</th>
                                    <td>{{ $dosen->jurusandosen->jurusan ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Prodi</th>
                                    <td>{{ $dosen->prodidosen->nama_prodi ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Jabatan</th>
                                    <td>{{ $dosen->jabatan ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Bidang keahlian</th>
                                    <td>{{ $dosen->bidangkeahliandosen->bidangkeahlian ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Jabatan Fungsional</th>
                                    <td>{{ $dosen->jabatandosen->jabatan ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Email</th>
                                    <td>{{ $dosen->email ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">No Telp</th>
                                    <td>{{ $dosen->no_telp ?? 'Data tidak tersedia' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center mt-4">Data Dosen tidak ditemukan.</div>
        @endif
    </div>
@endsection
