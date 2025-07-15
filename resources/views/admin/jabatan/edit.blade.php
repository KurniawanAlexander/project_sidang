@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Edit Jabatan Fungsional</h2>

        <form action="{{ route('jabatan.update', $jabatan) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- <div class="mb-3">
                <label for="jabatan" class="form-label">Nama Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ $jabatan->jabatan }}" required>
            </div> --}}
            <div class="mb-3">
                <label for="jabatan" class="form-label">Nama Jabatan</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                    <option value="" disabled {{ old('jabatan', $jabatan->jabatan) == '' ? 'selected' : '' }}>Pilih
                        Jabatan</option>
                    <option value="Asisten Ahli"
                        {{ old('jabatan', $jabatan->jabatan) == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                    <option value="Lektor" {{ old('jabatan', $jabatan->jabatan) == 'Lektor' ? 'selected' : '' }}>Lektor
                    </option>
                    <option value="Lektor Kepala"
                        {{ old('jabatan', $jabatan->jabatan) == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                    <option value="Guru Besar (Profesor)"
                        {{ old('jabatan', $jabatan->jabatan) == 'Guru Besar (Profesor)' ? 'selected' : '' }}>Guru Besar
                        (Profesor)</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $jabatan->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Proses">
                <a href="/jabatan/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
