@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Dosen</h2>

        <!-- Form pencarian dan tombol tambah dosen sejajar -->
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('dosen.create') }}" class="btn btn-primary">Tambah Dosen</a>

            <!-- Form Pencarian -->
            <form action="{{ route('dosen.index') }}" method="GET" class="d-flex">
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

        <!-- Tabel Data Dosen -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Foto</th>
                        <th scope="col">Nama Dosen</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($dosen->isNotEmpty())
                        @foreach ($dosen as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ $loop->iteration + ($dosen->currentPage() - 1) * $dosen->perPage() }}
                                </td>
                                <td class="align-middle text-center">
                                    @if ($item->foto && $item->foto != '-')
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Dosen"
                                            style="max-width: 80px; height: auto; border: 1px solid #ddd; border-radius: 8px;">
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $item->nama_dosen ?? 'Data tidak tersedia' }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dosen.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <form action="{{ route('dosen.destroy', $item->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin mau menghapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="align-middle text-center text-muted">Dosen tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div class="d-flex justify-content-end mt-3">
            <div class="pagination gap-2">
                <!-- Previous Button -->
                @if ($dosen->onFirstPage())
                    <span class="btn btn-secondary btn-sm disabled">Previous</span>
                @else
                    <a href="{{ $dosen->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
                @endif

                <!-- Pagination Links -->
                @foreach ($dosen->getUrlRange(1, $dosen->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="btn btn-outline-primary btn-sm {{ $dosen->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Next Button -->
                @if ($dosen->hasMorePages())
                    <a href="{{ $dosen->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
                @else
                    <span class="btn btn-secondary btn-sm disabled">Next</span>
                @endif
            </div>
        </div>
    </div>
@endsection
