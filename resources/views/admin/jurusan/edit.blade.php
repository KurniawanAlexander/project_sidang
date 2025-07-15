@extends('layout.template')

@section('main')
    <h1 class="mb-3">Edit Data Jurusan</h1>
    <form action="/jurusan/{{ $jurusan->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Kode Jurusan</label>
            <input type="hidden" name="id" id="id" value="{{ $jurusan->id }}">
            <input type="text" class="form-control" name="kode_jurusan" value="{{ $jurusan->kode_jurusan }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <input type="text" class="form-control" name="jurusan" value="{{ $jurusan->jurusan }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" class="form-control" name="keterangan" value="{{ $jurusan->keterangan }}">
        </div>
        <div class="mb-3 d-flex justify-content-start gap-2">
            <input class="btn btn-primary d-inline" type="submit" name="submit" value="Proses">
            <a href="/jurusan/" class="btn btn-outline-primary d-inline">
                Kembali
            </a>
        </div>
    </form>
@endsection
