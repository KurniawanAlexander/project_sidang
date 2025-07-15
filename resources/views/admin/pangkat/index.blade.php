@extends('layout.template')

@section('main')

    <div class="container">
        <h2>Daftar Pangkat</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('pangkat.create') }}" class="btn btn-primary">Tambah Pangkat</a>



        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pangkat</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @if ($pangkat->count() > 0)
                        @foreach ($pangkat as $item)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $item->pangkat }}</td>
                                <td class="align-middle">
                                    <a href="/pangkat/{{ $item->id }}/edit" class="btn btn-warning ">
                                        Edit
                                    </a>
                                    <form action="/pangkat/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin mau menghapus data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger  m-0" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="align-middle text-center" colspan="11">Pangkat tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    @endsection
