@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Edit Pengajuan Proposal Tugas Akhir</h2>

        <form action="{{ route('tugasakhir.update', $tugasakhir->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Menentukan metode PUT untuk update -->

            <div class="mb-3">
                <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="mahasiswa_id" name="mahasiswa_id"
                    value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="judulproposal1" class="form-label">Judul Proposal 1</label>
                <input type="text" class="form-control" id="judulproposal1" name="judulproposal1"
                    value="{{ old('judulproposal1', $tugasakhir->judulproposal1) }}">
                @error('judulproposal1')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="judulproposal2" class="form-label">Judul Proposal 2</label>
                <input type="text" class="form-control" id="judulproposal2" name="judulproposal2"
                    value="{{ old('judulproposal2', $tugasakhir->judulproposal2) }}">
                @error('judulproposal2')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen Proposal (PDF)</label>
                <input type="file" class="form-control" id="dokumen" name="dokumen" accept=".pdf">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah dokumen.</small>
                @if ($tugasakhir->dokumen)
                    <a href="{{ Storage::url($tugasakhir->dokumen) }}" target="_blank" class="btn btn-link">Lihat
                        Dokumen Saat Ini</a>
                @endif
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Catatan</label>
                <textarea class="form-control" id="keterangan" rows="3" name="keterangan">{{ old('keterangan', $tugasakhir->keterangan) }}</textarea>
                @error('keterangan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Perbarui Proposal">
                <a href="/tugasakhir/1" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
