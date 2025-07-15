@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Pengguna</h2>

        <!-- Form pencarian dan tombol tambah pengguna sejajar -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Pengguna</a>

            <!-- Form Pencarian -->
            <form action="{{ route('user.index') }}" method="GET" class="d-flex">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder=""
                        value="{{ request()->input('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tabel Data Pengguna -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->isNotEmpty())
                        @foreach ($users as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td class="align-middle">{{ $item->name }}</td>
                                <td class="align-middle">{{ $item->email }}</td>
                                <td class="align-middle">{{ $item->role }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                                    <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin mau menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="align-middle text-center text-muted">Pengguna tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div class="d-flex justify-content-end mt-3">
            <div class="pagination gap-2">
                <!-- Previous Button -->
                @if ($users->onFirstPage())
                    <span class="btn btn-secondary btn-sm disabled">Previous</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
                @endif

                <!-- Pagination Links -->
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="btn btn-outline-primary btn-sm {{ $users->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Next Button -->
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
                @else
                    <span class="btn btn-secondary btn-sm disabled">Next</span>
                @endif
            </div>
        </div>
    </div>
@endsection
