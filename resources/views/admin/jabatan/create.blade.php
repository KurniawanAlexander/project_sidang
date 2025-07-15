@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Tambah Jabatan Fungsional</h2>

        <form action="{{ route('jabatan.store') }}" method="POST">
            @csrf
            {{-- <div class="mb-3">
                <label for="jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" name="jabatan" class="form-control" required>
            </div> --}}
            <div class="mb-3">
                <label for="jabatan" class="form-label">Nama Jabatan</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                    <option value="" disabled selected>Pilih Jabatan</option>
                    <option value="Asisten Ahli">Asisten Ahli</option>
                    <option value="Lektor">Lektor</option>
                    <option value="Lektor Kepala">Lektor Kepala</option>
                    <option value="Guru Besar (Profesor)">Guru Besar (Profesor)</option>
                </select>
                @error('jabatan')
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
                <a href="/jabatan/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
