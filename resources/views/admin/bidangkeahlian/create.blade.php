@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2>Tambah Bidang Keahlian</h2>

        <!-- Form Tambah Bidang Keahlian -->
        <form action="{{ route('bidangkeahlian.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="bidangkeahlian" class="form-label">Bidang Keahlian</label>
                <input type="text" name="bidangkeahlian" id="bidangkeahlian"
                    class="form-control @error('bidangkeahlian') is-invalid @enderror" value="{{ old('bidangkeahlian') }}"
                    required>
                @error('bidangkeahlian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="form-control @error('keterangan') is-invalid @enderror" required>{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Simpan dan Kembali -->
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary" type="submit" name="submit" value="Simpan">
                <a href="{{ route('bidangkeahlian.index') }}" class="btn btn-outline-primary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
