@extends('layout.template')

@section('main')
    <div class="container">
        <h2>Pengajuan Proposal Tugas Akhir</h2>

        <form action="{{ route('tugasakhir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="mahasiswa_id" name="mahasiswa_id"
                    value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="judulproposal1" class="form-label">Judul Proposal 1</label>
                <input type="text" class="form-control" id="judulproposal1" name="judulproposal1" required>
            </div>

            <div class="mb-3">
                <label for="judulproposal2" class="form-label">Judul Proposal 2</label>
                <input type="text" class="form-control" id="judulproposal2" name="judulproposal2" required>
            </div>

            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen Proposal (PDF)</label>
                <input type="file" class="form-control" id="dokumen" name="dokumen" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <div class="mb-3 d-flex justify-content-start gap-2">
                <input class="btn btn-primary d-inline" type="submit" name="submit" value="Ajukan Proposal">
                <a href="/tugasakhir/" class="btn btn-outline-primary d-inline">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
