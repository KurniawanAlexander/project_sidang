@extends('layout.template')

@section('main')
    <div class="card m-3 p-4 shadow-sm">
        <h1 class="mb-4">Edit Data Mahasiswa</h1>
        <form action="/mahasiswa/{{ $mahasiswa->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>

                <!-- Tampilkan foto sebelumnya jika ada -->
                @if ($mahasiswa->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto" class="img-thumbnail"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                @endif

                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto"
                    accept="image/*">
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="hidden" name="id" id="id" value="{{ $mahasiswa->id }}">
                <input type="text" class="form-control" name="nama" id="nama" value="{{ $mahasiswa->nama }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" name="nim" id="nim" value="{{ $mahasiswa->nim }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Jurusan</label>
                <select class="form-select" name="kode_jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusan as $item)
                        <option value="{{ $item->id }}" {{ $item->id == $mahasiswa->kode_jurusan ? 'selected' : '' }}>
                            {{ $item->jurusan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_prodi" class="form-label">Prodi</label>
                <select class="form-select" name="kode_prodi" required>
                    <option value="">Pilih Prodi</option>
                    @foreach ($prodi as $prodis)
                        <option value="{{ $prodis->id }}" {{ $prodis->id == $mahasiswa->kode_prodi ? 'selected' : '' }}>
                            {{ $prodis->nama_prodi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div>
                    <input type="radio" class="form-check-input" name="gender" value="L"
                        {{ $mahasiswa->gender == 'L' ? 'checked' : '' }} id="gender_laki">
                    <label class="form-check-label" for="gender_laki">Laki-laki</label>
                    <input type="radio" class="form-check-input" name="gender" value="P"
                        {{ $mahasiswa->gender == 'P' ? 'checked' : '' }} id="gender_perempuan">
                    <label class="form-check-label" for="gender_perempuan">Perempuan</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $mahasiswa->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="no_telp">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                    value="{{ old('no_telp', $mahasiswa->no_telp) }}" required>
                @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Proses">
                <a href="/mahasiswa/1" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
