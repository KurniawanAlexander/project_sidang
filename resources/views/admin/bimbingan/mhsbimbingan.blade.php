@extends('layout.template')

@section('main')
    <h2>Mahasiswa Bimbingan</h2>

    @if (session()->has('Success'))
        <div class="alert alert-success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif

    <div class="table-responsive">
        <table id="example2" class="table table-bordered ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Judul Tugas Akhir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tugasakhirmahasiswa->nama ?? 'Tidak ada data' }}</td>
                        <td>{{ $item->pilihjudul ?? 'Tidak ada data' }}</td>
                        <td>
                            <a href="/detailmhsbimbingan/{{ $item->id }}" class="btn btn-info btn-sm"><b>Detail</b></a>
                            <a href="/kartubimbingan/{{ $item->id }}" class="btn btn-primary btn-sm"><b>Kartu
                                    Bimbingan</b></a>
                            @if (!$item->id)
                                <span class="text-danger">ID Tidak Valid</span>
                            @endif

                            @cannot('isKetuaprodi')
                                <a href="/gantipembimbing/{{ $item->id }}" class="btn btn-warning btn-sm mt-2">Ganti
                                    Pembimbing</a>
                            @endcannot
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
