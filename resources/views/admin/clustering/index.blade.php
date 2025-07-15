@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Clustering</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form pencarian dan tombol tambah clustering sejajar -->
        <div class="d-flex justify-content-between mb-3">
            <div class="d-flex gap-2">
                <a href="{{ route('clustering.create') }}" class="btn btn-primary">Tambah Clustering</a>
                <a href="/klaster" class="btn btn-primary">Cluster</a>
            </div>
            <form action="{{ route('clustering.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Judul Proposal"
                        value="{{ request()->input('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Mahasiswa</th>
                        <th scope="col">Judul Proposal</th>
                        <th scope="col">Klaster</th>
                        <th scope="col">Label</th>
                        <th scope="col">Abstrak</th>
                        <th scope="col">Kata Kunci</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Dosen</th>
                        <th scope="col">Keahlian Dosen</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Status Proposal</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clustering->count() > 0)
                        @foreach ($clustering as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ $loop->iteration + ($clustering->currentPage() - 1) * $clustering->perPage() }}
                                </td>
                                <td class="align-middle">{{ $item->mahasiswa }}</td>
                                <td class="align-middle">{{ $item->judul_proposal }}</td>
                                <td class="align-middle">{{ $item->klaster }}</td>
                                <td class="align-middle">{{ $item->label }}</td>
                                <td class="align-middle">{{ $item->abstrak }}</td>
                                <td class="align-middle">{{ $item->kata_kunci }}</td>
                                <td class="align-middle">{{ $item->nim }}</td>
                                <td class="align-middle">{{ $item->dosen ?? '-' }}</td>
                                <td class="align-middle">{{ $item->keahlian_dosen ?? '-' }}</td>
                                <td class="align-middle">{{ $item->tahun }}</td>
                                <td class="align-middle">{{ $item->status_proposal }}</td>
                                <td class="align-middle">{{ $item->keterangan ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('clustering.edit', $item->id) }}"
                                        class="btn btn-info btn-sm">Edit</a>
                                    <form action="{{ route('clustering.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin mau menghapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" class="align-middle text-center text-muted">Data proposal clustering tidak
                                ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Navigasi pagination dengan teks Previous dan Next -->
            <div class="d-flex justify-content-end mt-3">
                <div class="pagination gap-2">
                    @if ($clustering->onFirstPage())
                        <span class="btn btn-secondary btn-sm disabled">Previous</span>
                    @else
                        <a href="{{ $clustering->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
                    @endif

                    @foreach ($clustering->getUrlRange(1, $clustering->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="btn btn-outline-primary btn-sm {{ $clustering->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($clustering->hasMorePages())
                        <a href="{{ $clustering->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
                    @else
                        <span class="btn btn-secondary btn-sm disabled">Next</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
