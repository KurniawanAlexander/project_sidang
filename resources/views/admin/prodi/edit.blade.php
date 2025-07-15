@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Edit Prodi</h2>

        <form action="{{ route('prodi.update', $prodi) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                <input type="text" name="kode_prodi" class="form-control @error('kode_prodi') is-invalid @enderror"
                    value="{{ old('kode_prodi', $prodi->kode_prodi) }}" required>
                @error('kode_prodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror"
                    value="{{ old('nama_prodi', $prodi->nama_prodi) }}" required>
                @error('nama_prodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenjang" class="form-label">Edit Jenjang</label>
                <select class="form-control @error('jenjang') is-invalid @enderror" id="jenjang" name="jenjang" required>
                    <option value="" disabled>Pilih Jenjang</option>
                    <option value="D2" {{ old('jenjang', $prodi->jenjang) == 'D2' ? 'selected' : '' }}>D2</option>
                    <option value="D3" {{ old('jenjang', $prodi->jenjang) == 'D3' ? 'selected' : '' }}>D3</option>
                    <option value="D4" {{ old('jenjang', $prodi->jenjang) == 'D4' ? 'selected' : '' }}>D4</option>
                    <option value="S1" {{ old('jenjang', $prodi->jenjang) == 'S1' ? 'selected' : '' }}>S1</option>
                    <option value="S2" {{ old('jenjang', $prodi->jenjang) == 'S2' ? 'selected' : '' }}>S2</option>
                </select>
                @error('jenjang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="akreditasi" class="form-label">Akreditasi</label>
                <select class="form-control @error('akreditasi') is-invalid @enderror" id="akreditasi" name="akreditasi"
                    required>
                    <option value="" disabled>Pilih Akreditasi</option>
                    <option value="Unggul (A)"
                        {{ old('akreditasi', $prodi->akreditasi) == 'Unggul (A)' ? 'selected' : '' }}>Unggul (A)</option>
                    <option value="Baik Sekali (B)"
                        {{ old('akreditasi', $prodi->akreditasi) == 'Baik Sekali (B)' ? 'selected' : '' }}>Baik Sekali (B)
                    </option>
                    <option value="Baik (C)" {{ old('akreditasi', $prodi->akreditasi) == 'Baik (C)' ? 'selected' : '' }}>
                        Baik (C)</option>
                    <option value="Tidak Terakreditasi"
                        {{ old('akreditasi', $prodi->akreditasi) == 'Tidak Terakreditasi' ? 'selected' : '' }}>Tidak
                        Terakreditasi</option>
                </select>
                @error('akreditasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tahunberdiri" class="form-label">Tahun Berdiri</label>
                <input type="text" name="tahunberdiri" class="form-control @error('tahunberdiri') is-invalid @enderror"
                    value="{{ old('tahunberdiri', $prodi->tahunberdiri) }}">
                @error('tahunberdiri')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $prodi->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Proses">
                <a href="/prodi/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
