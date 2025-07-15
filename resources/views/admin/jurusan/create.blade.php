@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Jurusan</h2>

        <form action="{{ route('jurusan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Kode jurusan</label>
                <input type="text" name="kode_jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Nama jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan">
                <a href="/jurusan/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
