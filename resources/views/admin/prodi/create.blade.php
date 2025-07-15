@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Prodi</h2>

        <form action="{{ route('prodi.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                <input type="text" name="kode_prodi" class="form-control @error('kode_prodi') is-invalid @enderror"
                    required>
                @error('kode_prodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror"
                    required>
                @error('nama_prodi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select class="form-control @error('jenjang') is-invalid @enderror" id="jenjang" name="jenjang" required>
                    <option value="" disabled selected>Pilih Jenjang</option>
                    <option value="D2">D2</option>
                    <option value="D3">D3</option>
                    <option value="D4">D4</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                </select>
                @error('jenjang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="akreditasi" class="form-label">Akreditasi</label>
                <select class="form-select @error('akreditasi') is-invalid @enderror" id="akreditasi" name="akreditasi"
                    required>
                    <option value="" disabled selected>Pilih Akreditasi</option>
                    <option value="Unggul (A)">Unggul (A)</option>
                    <option value="Baik Sekali (B)">Baik Sekali (B)</option>
                    <option value="Baik (C)">Baik (C)</option>
                    <option value="Tidak Terakreditasi">Tidak Terakreditasi</option>
                </select>
                @error('akreditasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tahunberdiri" class="form-label">Tahun Berdiri</label>
                <input type="text" class="form-control @error('tahunberdiri') is-invalid @enderror" id="tahunberdiri"
                    name="tahunberdiri">
                @error('tahunberdiri')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"></textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan">
                <a href="/prodi/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
