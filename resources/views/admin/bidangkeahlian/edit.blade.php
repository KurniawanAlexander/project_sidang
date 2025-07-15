@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Edit Bidang Keahlian</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('bidangkeahlian.update', $bidangkeahlian->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Bidang Keahlian -->
            <div class="mb-3">
                <label for="bidangkeahlian" class="form-label">Nama Bidang Keahlian</label>
                <input type="text" name="bidangkeahlian" class="form-control @error('bidangkeahlian') is-invalid @enderror"
                    value="{{ old('bidangkeahlian', $bidangkeahlian->bidangkeahlian) }}" required>
                @error('bidangkeahlian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan', $bidangkeahlian->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-start gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('bidangkeahlian.index') }}" class="btn btn-outline-primary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
