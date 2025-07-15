@extends('layout.template')

@section('main')
    <style>
        p {
            margin: 0;
            /* Menghapus margin bawaan pada elemen <p> */
        }

        .form-section {
            margin-top: 1rem;
            /* Memberikan jarak antara paragraf dan form */
        }
    </style>
    @if (session()->has('Success'))
        <div class="alert alert-success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <h5 class="mb-3">Daftar Sidang Tugas Akhir</h5>
    <p>Dengan melakukan upload Dokumen, ini berarti anda mengajukan permintaan untuk melakukan Sidang Tugas Akhir.</p>
    <p>Pastikan anda mengupload Dokumen proposal anda</p>
    <form method="post" action="/sita" enctype="multipart/form-data" class="form-section">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="dokumen" class="form-label">Upload Dokumen</label>
                <input class="form-control @error('dokumen') is-invalid @enderror" type="file" id="dokumen"
                    name="dokumen" accept=".pdf" onchange="previewImage(event)" required>
                @error('dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-end gap-2">
            <input class="btn btn-primary" type="submit" name="submit" value="Ajukan Sidang TA">
            <a href="/sita/" class="btn btn-outline-primary">
                Kembali
            </a>
        </div>
    </form>
@endsection
