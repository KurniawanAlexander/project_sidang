@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Edit Dosen</h2>

        <form action="{{ route('dosen.update', $dosen) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>

                <!-- Tampilkan foto sebelumnya jika ada -->
                @if ($dosen->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $dosen->foto) }}" alt="foto"
                            style="width: 150px; height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                @endif

                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto"
                    accept="image/*">

                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Dosen</label>
                <input type="hidden" name="id" id="id" value="{{ $dosen->id }}">
                <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" name="nama_dosen"
                    value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
                @error('nama_dosen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip"
                    value="{{ old('nip', $dosen->nip) }}" required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">NIDN</label>
                <input type="text" class="form-control @error('nidn') is-invalid @enderror" name="nidn"
                    value="{{ old('nidn', $dosen->nidn) }}" required>
                @error('nidn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-1">
                <label class="form-label">Gender</label>
            </div>
            <div class="mb-3">
                <input type="radio" class="form-check-input" name="gender" value="Laki-laki"
                    {{ old('gender', $dosen->gender) == 'Laki-laki' ? 'checked' : '' }} required> Laki-laki
                <input type="radio" class="form-check-input" name="gender" value="Perempuan"
                    {{ old('gender', $dosen->gender) == 'Perempuan' ? 'checked' : '' }} required> Perempuan
                @error('gender')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="kode_jurusan">Jurusan</label>
                <select class="form-select @error('kode_jurusan') is-invalid @enderror" name="kode_jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    @foreach ($jurusan as $jurusans)
                        <option value="{{ $jurusans->id }}"
                            {{ old('kode_jurusan', $dosen->kode_jurusan) == $jurusans->id ? 'selected' : '' }}>
                            {{ $jurusans->jurusan }}</option>
                    @endforeach
                </select>
                @error('kode_jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="kode_prodi">Prodi</label>
                <select class="form-select @error('kode_prodi') is-invalid @enderror" name="kode_prodi" required>
                    <option value="">Pilih Prodi</option>
                    @foreach ($prodi as $prodis)
                        <option value="{{ $prodis->id }}"
                            {{ old('kode_prodi', $dosen->kode_prodi) == $prodis->id ? 'selected' : '' }}>
                            {{ $prodis->nama_prodi }}</option>
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
                    <option value="Dosen">Dosen</option>
                    <option value="Kaprodi">Kepala Prodi</option>
                    <option value="Kajur">Kepala Jurusan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="bidangkeahlian">Bidang Keahlian</label>
                <select class="form-select @error('bidangkeahlian') is-invalid @enderror" name="bidangkeahlian" required>
                    <option value="">Pilih Bidang Keahlian</option>
                    @foreach ($bidangkeahlian as $item)
                        <option value="{{ $item->id }}"
                            {{ old('bidangkeahlian', $dosen->bidangkeahlian) == $item->id ? 'selected' : '' }}>
                            {{ $item->bidangkeahlian }}
                        </option>
                    @endforeach
                </select>
                @error('bidangkeahlian')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="jabatan_id">Jabatan Fungsional</label>
                <select class="form-select @error('jabatan_id') is-invalid @enderror" name="jabatan_id" required>
                    <option value="">Pilih Jabatan Fungsional</option>
                    @foreach ($jabatan as $jabatans)
                        <option value="{{ $jabatans->id }}"
                            {{ old('jabatan_id', $dosen->jabatan) == $jabatans->id ? 'selected' : '' }}>
                            {{ $jabatans->jabatan }}</option>
                    @endforeach
                </select>
                @error('jabatan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $dosen->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="no_telp">No Telp</label>
                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp"
                    value="{{ old('no_telp', $dosen->no_telp) }}" required>
                @error('no_telp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- <div class="mb-3">
        <label for="foto" class="col-sm-2 col-form-label">Ganti Foto</label>
        <div class="col-sm-10">
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" id="foto">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div> --}}
            {{-- <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_aktif" value="aktif" {{ old('status', $dosens->status) == 'aktif' ? 'checked' : '' }} required>
                <label class="form-check-label" for="status_aktif">Aktif</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_cuti" value="cuti" {{ old('status', $dosens->status) == 'cuti' ? 'checked' : '' }} required>
                <label class="form-check-label" for="status_cuti">Cuti</label>
            @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            </div>
        </div>
    </div> --}}
            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Proses">
                <a href="/dosen/1" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    @endsection
