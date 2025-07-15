@extends('layout.template')

@section('main')
    @if (session()->has('Success'))
        <div class="alert alert-success" role="alert">
            {{ session('Success') }}
        </div>
    @elseif(session()->has('Failed'))
        <div class="alert alert-danger" role="alert">
            {{ session('Failed') }}
        </div>
    @endif
    <form method="post" action="/sitajadwal/{{ $sita->id }}" enctype="multipart/form-data">
        @csrf
        <div class="width-75">
            <div class="mb-3">
                <label for="ketuasidang_id" class="form-label">Ketua Sidang</label>
                <select name="ketuasidang_id" id="ketuasidang_id"
                    class="form-select @error('ketuasidang_id') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih</option>
                    <option value="{{ $sita->sitatugasakhir->pembimbingta1->id }}"
                        @if (old('ketuasidang_id') == $sita->sitatugasakhir->pembimbingta1->id) selected @endif>
                        {{ $sita->sitatugasakhir->pembimbingta1->nama_dosen }}
                    </option>
                    <option value="{{ $sita->sitatugasakhir->pembimbingta2->id }}"
                        @if (old('ketuasidang_id') == $sita->sitatugasakhir->pembimbingta2->id) selected @endif>
                        {{ $sita->sitatugasakhir->pembimbingta2->nama_dosen }}
                    </option>
                </select>
                @error('ketuasidang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="sekretaris_id" class="form-label">Sekretaris Sidang</label>
                <br>
                <select name="sekretaris_id" class="form-select @error('sekretaris_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($dosen as $item)
                        <option value="{{ $item->id }}" @if (old('sekretaris_id') == $item->id) selected @endif>
                            {{ $item->nama_dosen }}</option>
                    @endforeach
                </select>
                @error('sekretaris_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="penguji1_id" class="form-label">Penguji Satu</label>
                <br>
                <select name="penguji1_id" class="form-select @error('penguji1_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($dosen as $item)
                        <option value="{{ $item->id }}" @if (old('penguji1_id') == $item->id) selected @endif>
                            {{ $item->nama_dosen }}</option>
                    @endforeach
                </select>
                @error('penguji1_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="penguji2_id" class="form-label">Penguji Dua</label>
                <br>
                <select name="penguji2_id" class="form-select @error('penguji2_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($dosen as $item)
                        <option value="{{ $item->id }}" @if (old('penguji2_id') == $item->id) selected @endif>
                            {{ $item->nama_dosen }}</option>
                    @endforeach
                </select>
                @error('penguji2_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tgl_sita" class="form-label">Tanggal dan Waktu Seminar Proposal</label>
                <input type="datetime-local" class="form-control @error('tgl_sita') is-invalid @enderror" id="tgl_sita"
                    name="tgl_sita"
                    value="{{ old('tgl_sita', isset($sita) && $sita->tgl_sita ? $sita->tgl_sita->format('Y-m-d\TH:i') : '') }}"
                    required>
                @error('tgl_sita')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="ruangan_id" class="form-label">Ruangan</label>
                <br>
                <select name="ruangan_id" class="form-select @error('ruangan_id') is-invalid @enderror" required>
                    <option value="-" class="form-control">Pilih</option>
                    @foreach ($ruangan as $item)
                        <option value="{{ $item->id }}" @if (old('ruangan_id') == $item->id) selected @endif>
                            {{ $item->ruangan }}-{{ $item->kode_ruangan }}</option>
                    @endforeach
                </select>
                @error('ruangan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
