@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Tambah Data Clustering</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ups!</strong> Ada kesalahan dalam input:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clustering.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="mahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="mahasiswa" value="{{ old('mahasiswa') }}" required>
            </div>

            <div class="mb-3">
                <label for="judul_proposal" class="form-label">Judul Proposal</label>
                <input type="text" class="form-control" name="judul_proposal" value="{{ old('judul_proposal') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="abstrak" class="form-label">Abstrak</label>
                <textarea class="form-control" name="abstrak" rows="3" required>{{ old('abstrak') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="kata_kunci" class="form-label">Kata Kunci</label>
                <input type="text" class="form-control" name="kata_kunci" value="{{ old('kata_kunci') }}" required>
            </div>

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" name="nim" value="{{ old('nim') }}" required>
            </div>

            <div class="mb-3">
                <label for="dosen" class="form-label">Dosen (hasil clustering)</label>
                <input type="text" class="form-control" name="dosen" value="{{ old('dosen') }}">
            </div>

            <div class="mb-3">
                <label for="keahlian_dosen" class="form-label">Keahlian Dosen (hasil clustering)</label>
                <input type="text" class="form-control" name="keahlian_dosen" value="{{ old('keahlian_dosen') }}">
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" name="tahun" value="{{ old('tahun') }}" required>
            </div>

            <div class="mb-3">
                <label for="status_proposal" class="form-label">Status Proposal</label>
                <select class="form-select" name="status_proposal" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="pending" {{ old('status_proposal') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima" {{ old('status_proposal') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ old('status_proposal') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('clustering.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
