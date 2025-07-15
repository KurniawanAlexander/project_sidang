@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Jabatan Fungsional</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3">Tambah Jabatan</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Nama Jabatan</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($jabatan->count() > 0)
                        @foreach ($jabatan as $item)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $item->jabatan }}</td>
                                <td class="align-middle">{{ $item->keterangan }}</td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('jabatan.edit', $item->id) }}" class="btn btn-info btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('jabatan.destroy', $item->id) }}" method="POST" class="d-inline"
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
                            <td colspan="3" class="align-middle text-center text-muted">Jabatan tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
