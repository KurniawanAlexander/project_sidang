@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Jurusan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @can('isSuperAdmin')
            <a href="{{ route('jurusan.create') }}" class="btn btn-primary mb-3">Tambah Jurusan</a>
        @endcan
        @can('isAdmin')
            <a href="/jurusan" class="btn btn-primary mb-3">lihat Jurusan</a>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Kode Jurusan</th>
                        <th scope="col">Nama Jurusan</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($jurusan->count() > 0)
                        @foreach ($jurusan as $item)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $item->kode_jurusan }}</td>
                                <td class="align-middle">{{ $item->jurusan }}</td>
                                <td class="align-middle">{{ $item->keterangan }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('jurusan.edit', $item->id) }}" class="btn btn-info btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('jurusan.destroy', $item->id) }}" method="POST" class="d-inline"
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
                            <td colspan="5" class="align-middle text-center text-muted">Jurusan tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
