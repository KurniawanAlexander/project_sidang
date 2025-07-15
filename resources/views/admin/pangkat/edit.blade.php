@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Edit Pangkat</h2>

        <form action="{{ route('pangkat.update', $pangkat) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="pangkat" class="form-label">Nama Pangkat</label>
                <input type="text" name="pangkat" class="form-control" value="{{ $pangkat->pangkat }}" required>
                <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
@endsection
