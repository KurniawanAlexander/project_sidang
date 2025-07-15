@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Pangkat</h2>

        <form action="{{ route('pangkat.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="pangkat" class="form-label">Nama Pangkat</label>
                <input type="text" name="pangkat" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
