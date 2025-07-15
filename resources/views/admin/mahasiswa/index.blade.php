@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Mahasiswa</h2>

        <!-- Form pencarian dan tombol tambah mahasiswa sejajar -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">Tambah Mahasiswa</a>
            <!-- Form Pencarian -->
            <form action="{{ route('mahasiswa.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder=""
                        value="{{ request()->input('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>

            <!-- Tombol Tambah Mahasiswa -->
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($mahasiswa->isNotEmpty())
                        @foreach ($mahasiswa as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ $loop->iteration + ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() }}
                                </td>
                                <td class="align-middle text-center">
                                    @if ($item->foto && $item->foto != '-')
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Mahasiswa"
                                            class="rounded" style="width: 80px; height: auto; border: 1px solid #ddd;">
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $item->nama ?? 'Data tidak tersedia' }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('mahasiswa.show', $item->id) }}" class="btn btn-info btn-sm">
                                        Detail
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST"
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
                            <td colspan="4" class="align-middle text-center text-muted">Mahasiswa tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Navigasi pagination dengan teks Previous dan Next -->
            <div class="d-flex justify-content-end mt-3">
                <div class="pagination gap-2">
                    <!-- Previous Button -->
                    @if ($mahasiswa->onFirstPage())
                        <span class="btn btn-secondary btn-sm disabled">Previous</span>
                    @else
                        <a href="{{ $mahasiswa->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
                    @endif

                    <!-- Pagination Links -->
                    @foreach ($mahasiswa->getUrlRange(1, $mahasiswa->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="btn btn-outline-primary btn-sm {{ $mahasiswa->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    <!-- Next Button -->
                    @if ($mahasiswa->hasMorePages())
                        <a href="{{ $mahasiswa->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
                    @else
                        <span class="btn btn-secondary btn-sm disabled">Next</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
