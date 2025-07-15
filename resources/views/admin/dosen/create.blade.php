@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Dosen</h2>

        <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto"
                    accept="image/*">
                @error('foto')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nama_dosen">Nama Dosen</label>
                <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" name="nama_dosen"
                    value="{{ old('nama_dosen') }}" required>
                @error('nama_dosen')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nip">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                    value="{{ old('nip') }}" required>
                @error('nip')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="nip">NIDN</label>
                <input type="text" class="form-control @error('nidn') is-invalid @enderror" name="nidn"
                    value="{{ old('nidn') }}" required>
                @error('nidn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" name="gender" value="Laki-laki" checked> Laki-laki
                <input type="radio" name="gender" value="Perempuan"> Perempuan
                @error('gender')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="kode_jurusan">Jurusan</label>
                <select class="form-select @error('kode_jurusan') is-invalid @enderror" name="kode_jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusan as $item)
                        <option value="{{ $item->id }}" {{ old('kode_jurusan') == $item->id ? 'selected' : '' }}>
                            {{ $item->jurusan }}</option>
                    @endforeach
                </select>
                @error('kode_jurusan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="kode_prodi">Prodi</label>
                <select class="form-select @error('kode_prodi') is-invalid @enderror" name="kode_prodi" required>
                    <option value="">Pilih Prodi</option>
                    @foreach ($prodi as $item)
                        <option value="{{ $item->id }}" {{ old('kode_prodi') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_prodi }}</option>
                    @endforeach
                </select>
                @error('kode_prodi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <select class="form-control" id="jabatan" name="jabatan" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Kajur">Kepala Jurusan</option>
                    <option value="Kaprodi">Kepala Prodi</option>
                    <option value="Dosen">Dosen</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="bidangkeahlian">Bidang Keahlian</label>
                <select class="form-select @error('bidangkeahlian') is-invalid @enderror" name="bidangkeahlian" required>
                    <option value="">Pilih Bidang Keahlian</option>
                    @foreach ($bidangkeahlian as $item)
                        <option value="{{ $item->id }}" {{ old('bidangkeahlian') == $item->id ? 'selected' : '' }}>
                            {{ $item->bidangkeahlian }}</option>
                    @endforeach
                </select>
                @error('bidangkeahlian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="jabatan">Jabatan Fungsional</label>
                <select class="form-select @error('jabatan') is-invalid @enderror" name="jabatan_id" required>
                    <option value="">Pilih Jabatan Fungsional</option>
                    @foreach ($jabatan as $item)
                        <option value="{{ $item->id }}" {{ old('jabatan') == $item->id ? 'selected' : '' }}>
                            {{ $item->jabatan }}</option>
                    @endforeach
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="no_telp">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                    value="{{ old('no_telp') }}" required>
                @error('no_telp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            {{-- <div class="mb-3">
        <label for="foto" class="col-sm-2 col-form-label">Foto:</label>
        <div class="col-sm-10">
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto">
            @error('foto')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div> --}}
            {{-- <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_aktif" value="aktif" {{ old('status') == 'aktif' ? 'checked' : '' }} required>
                <label class="form-check-label" for="status_aktif">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_cuti" value="cuti" {{ old('status') == 'cuti' ? 'checked' : '' }} required>
                <label class="form-check-label" for="status_cuti">Cuti</label>
            @error('status')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
            </div>
        </div>
    </div> --}}
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Simpan">
                <a href="/dosen/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    @endsection
