@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="/mahasiswa" class="btn btn-outline-primary">
                Kembali
            </a>
            <h2 class="mb-0 text-center flex-grow-1">Detail Mahasiswa</h2>
            <a href="/mahasiswa/{{ $mahasiswa->id }}/edit" class="btn btn-primary ms-3">
                <i class="fas fa-edit"></i> Edit Data
            </a>
        </div>

        @if ($mahasiswa)
            <div class="card shadow-sm p-4">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="mb-3">
                            @if ($mahasiswa->foto == '-')
                                <div class="border p-4 bg-light text-muted">Foto tidak tersedia</div>
                            @else
                                <img src="{{ asset('storage/' . $mahasiswa->foto) }}?{{ time() }}"
                                    alt="Foto Mahasiswa" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="bg-light" style="width: 150px;">Nama</th>
                                    <td>{{ $mahasiswa->nama ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light" style="width: 150px;">NIM</th>
                                    <td>{{ $mahasiswa->nim ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light" style="width: 150px;">kelas</th>
                                    <td>{{ $mahasiswa->kelas ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Jurusan</th>
                                    <td>{{ $mahasiswa->jurusanmahasiswa->jurusan ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Prodi</th>
                                    <td>{{ $mahasiswa->dataprodi->jenjang ?? 'Data tidak tersedia' }}
                                        {{ $mahasiswa->dataprodi->nama_prodi }}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Gender</th>
                                    <td>
                                        @if ($mahasiswa->gender === 'Laki-laki')
                                            Laki-laki
                                        @elseif ($mahasiswa->gender === 'Perempuan')
                                            Perempuan
                                        @else
                                            Data tidak tersedia
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">Email</th>
                                    <td>{{ $mahasiswa->email ?? 'Data tidak tersedia' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" class="bg-light">No Telp</th>
                                    <td>{{ $mahasiswa->no_telp ?? 'Data tidak tersedia' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center mt-4">Data Mahasiswa tidak ditemukan.</div>
        @endif
    </div>
@endsection
