@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Kartu Bimbingan</h2>

        <div class="row align-items-center mb-3">
            @can('isMahasiswa')
                <div class="col-auto">
                    <a href="{{ route('bimbingan.create') }}" class="btn btn-primary">Tambah Bimbingan Baru</a>
                </div>
            @endcan

            <div class="col">
                <form action="{{ isset($cek) ? '/kartubimbingan/' . $cek->id : '#' }}" method="GET"
                    class="d-flex justify-content-end">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari pembahasan"
                            value="{{ request()->input('search') }}">
                        <button class="btn btn-outline-primary" type="submit"
                            {{ !isset($cek) ? 'disabled' : '' }}>Cari</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Notifikasi -->
        @if (session()->has('Success'))
            <div class="alert alert-success" role="alert">
                {{ session('Success') }}
            </div>
        @elseif(session()->has('Failed'))
            <div class="alert alert-danger" role="alert">
                {{ session('Failed') }}
            </div>
        @endif


        <!-- Tabel Data -->
        <div class="table-responsive">
            <table id="example2" class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal Bimbingan</th>
                        @can('isMahasiswa')
                            <th class="text-center">Nama Pembimbing</th>
                        @endcan
                        <th class="text-center">Status Verifikasi</th>
                        <th class="text-center">Pembahasan</th>
                        <th class="text-center">Aksi</th>
                        {{-- @can('isMahasiswa')
                        @endcan --}}
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isNotEmpty())
                        @foreach ($data as $index => $item)
                            <tr>
                                <td class="align-middle text-center">
                                    {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                </td>
                                <td class="align-middle text-center">{{ $item->tgl_bimbingan }}</td>
                                @can('isMahasiswa')
                                    <td class="align-middle text-center">
                                        {{ $item->dosenpembimbing->nama_dosen ?? 'Tidak ada data' }}
                                    </td>
                                @endcan
                                <td>
                                    @if ($item->validasi == 0)
                                        Belum Diverifikasi
                                    @else
                                        Sudah Diverifikasi
                                    @endif
                                </td>
                                <td class="align-middle">{{ strip_tags($item->pembahasan) }}</td>
                                @can('isMahasiswa')
                                    <td class="align-middle text-center">
                                        <a href="{{ route('bimbingan.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('bimbingan.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                @endcan
                                @can('isDosen')
                                    <td class="align-middle text-center">
                                        @if ($item->validasi == 0)
                                            <a href="/verifikasikartubimbingan/{{ $item->id }}"
                                                class="btn btn-info btn-sm">Validasi Bimbingan</a>
                                        @else
                                            <a href="/verifikasikartubimbingan/{{ $item->id }}"
                                                class="btn btn-info btn-sm">Sudah Validasi</a>
                                        @endif
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted">Data bimbingan tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination dan Tombol Kembali -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- Tombol Kembali -->
            @can('isDosen')
                <a href="/bimbingan/" class="btn btn-outline-primary">Kembali</a>
            @endcan

            <!-- Pagination -->
            <div class="pagination gap-2 d-flex justify-content-center">
                <!-- Tombol Previous -->
                @if ($data->onFirstPage())
                    <span class="btn btn-secondary btn-sm disabled">Previous</span>
                @else
                    <a href="{{ $data->previousPageUrl() }}" class="btn btn-primary btn-sm">Previous</a>
                @endif

                <!-- Pagination Links -->
                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="btn btn-outline-primary btn-sm {{ $data->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                <!-- Tombol Next -->
                @if ($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}" class="btn btn-primary btn-sm">Next</a>
                @else
                    <span class="btn btn-secondary btn-sm disabled">Next</span>
                @endif
            </div>


        </div>

    @endsection
