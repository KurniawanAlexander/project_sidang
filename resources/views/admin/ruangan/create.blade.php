@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Ruangan</h2>

        <form action="{{ route('ruangan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode_ruangan" class="form-label">Kode Ruangan</label>
                <input type="text" name="kode_ruangan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="ruangan" class="form-label">Nama Ruangan</label>
                <input type="text" name="ruangan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jam" class="form-label">Jam</label>
                <input type="time" name="jam" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan">
                <a href="/ruangan/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
