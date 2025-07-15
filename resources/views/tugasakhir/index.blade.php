@extends('layout.template')

@section('main')
    <div class="container mt-4">
        <h2 class="mb-3">Daftar Pengajuan Proposal Tugas Akhir</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (Auth::user()->can('isMahasiswa'))
            <a href="{{ route('tugasakhir.create') }}" class="btn btn-primary mb-3">Ajukan Proposal Baru</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama Mahasiswa</th>
                            <th scope="col">Status Pengajuan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($tugasakhirs) && $tugasakhirs->count() > 0)
                            @foreach ($tugasakhirs as $item)
                                <tr>
                                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $item->tugasakhirmahasiswa->nama ?? 'Data tidak tersedia' }}
                                    </td>
                                    <td>
                                        @if ($item->status_usulan == '0')
                                            <span>Pengajuan</span>
                                        @elseif ($item->status_usulan == '1')
                                            <span class="text-success">Diterima</span>
                                        @elseif ($item->status_usulan == '2')
                                            <span class="text-warning">Revisi</span>
                                        @elseif ($item->status_usulan == '3')
                                            <span class="text-danger">Ditolak</span>
                                        @elseif ($item->status_usulan == '4')
                                            <span class="text-info">Diajukan Kembali</span>
                                        @endif
                                    </td>

                                    <td class="align-middle text-center">
                                        <a href="{{ route('tugasakhir.show', $item->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        @if ($item->status_usulan == '0' || $item->status_usulan == '3')
                                            <form action="{{ route('tugasakhir.destroy', $item->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin mau menghapus data?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada pengajuan proposal ditemukan.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @elseif (Auth::user()->can('isKaprodi'))
            <div class="table-responsive">
                <table id="tugasakhir" class="table table-bordered mt-4">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col">Nama Mahasiswa</th>
                                <th scope="col">Status Pengajuan</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tugasakhirs) && $tugasakhirs->count() > 0)
                                @foreach ($tugasakhirs as $item)
                                    <tr>
                                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                        <td class="align-middle">
                                            {{ $item->tugasakhirmahasiswa->nama }}</td>
                                        <td>
                                            @if ($item->status_usulan == '0')
                                                <span>Pengajuan</span>
                                            @elseif ($item->status_usulan == '1')
                                                <span>Diterima</span>
                                            @elseif ($item->status_usulan == '2')
                                                <span>Revisi</span>
                                            @elseif ($item->status_usulan == '3')
                                                <span>Ditolak</span>
                                            @elseif ($item->status_usulan == '4')
                                                <span>Diajukan Kembali</span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center">
                                            <a href="{{ route('tugasakhir.show', $item->id) }}" class="btn btn-info btn-sm">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada pengajuan proposal
                                        ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </table>
            </div>
        @endif

    </div>
@endsection
