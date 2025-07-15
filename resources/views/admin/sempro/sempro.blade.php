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

    @can('isMahasiswa')
        <table class="table table-bordered table-striped table-hover table-hover table-striped">
            <thead class="text-center">
                <tr>
                    <th colspan="2" class="bg-light">Detail Seminar Proposal</th>
                </tr>
            </thead>
            <tbody>
                {{-- Judul Proposal --}}
                <tr>
                    <th scope="row" style="width: 200px;">Judul Proposal</th>
                    <td>
                        {{ $sempro->semprotugasakhir->pilihjudul ?? 'Data tidak tersedia' }}
                    </td>
                </tr>

                {{-- Verifikasi Pembimbing --}}
                <tr>
                    <th scope="row">Verifikasi Pembimbing 1</th>
                    <td>
                        @if ($sempro->pembimbing1_acc === 0)
                            Belum Diverifikasi
                        @else
                            Sudah Diverifikasi
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Verifikasi Pembimbing 2</th>
                    <td>
                        @if ($sempro->pembimbing2_acc === 0)
                            Belum Diverifikasi
                        @else
                            Sudah Diverifikasi
                        @endif
                    </td>
                </tr>

                {{-- Penguji dan Tanggal Sidang --}}
                @if ($sempro->penguji_id != 0)
                    <tr>
                        <th scope="row">Penguji</th>
                        <td>{{ $sempro->pengujisempro->nama_dosen ?? 'Data tidak tersedia' }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Sidang</th>
                        <td>
                            {{ \Carbon\Carbon::parse($sempro->tgl_sempro)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Ruangan Sidang</th>
                        <td>
                            {{ $sempro->ruangansempro->kode_ruangan ?? 'Kode tidak tersedia' }}
                            {{ $sempro->ruangansempro->ruangan ?? 'Data tidak tersedia' }}
                        </td>
                    </tr>
                @endif

                {{-- Dokumen Proposal --}}
                <tr>
                    <th scope="row">Dokumen Proposal</th>
                    <td>
                        @if ($sempro->tugasakhir_id)
                            <a href="{{ Storage::url($sempro->semprotugasakhir->dokumen) }}" class="btn btn-secondary btn-sm"
                                target="_blank">Lihat Dokumen</a>
                        @else
                            <span>Tidak ada dokumen</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <a href="/downloadproposal/{{ $sempro->tugasakhir_id }}" class="btn btn-secondary btn-sm">Unduh
                            Dokumen</a>
                    </td>
                </tr>

                {{-- NILAI --}}
                @if ($sempro->status == 3 || $sempro->status == 4)
                    <tr>
                        <th scope="row">Nilai Sidang Proposal</th>
                        <td>{{ $sempro->nilaiakhir }}</td>
                    </tr>
                @endif

                {{-- Status --}}
                <tr>
                    <th scope="row">Status</th>
                    <td>
                        @if ($sempro->status == 0)
                            Sedang Diajukan
                        @elseif ($sempro->status == 1)
                            Sudah Dijadwalkan
                        @elseif ($sempro->status == 2)
                            Sedang Dinilai
                        @elseif ($sempro->status == 3)
                            Lulus
                        @elseif ($sempro->status == 4)
                            Tidak Lulus, <a href="/sempro/create">Daftar Lagi??</a>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>


        @if ($sempro->status == 3 || $sempro->status == 4)
            <h5 class="text-center mt-4">DETAIL PENILAIAN</h5>
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" class="bg-light" scope="row">Pembimbing Satu</th>
                            <th class="bg-light" scope="row">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 200px;">Pendahuluan</th>
                            <td>Mahasiswa mampu menjelaskan latar belakang, tujuan, dan kontribusi penelitian.</td>
                            <td class="text-center">{{ $pembimbing1->nl_pendahuluan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tinjauan Pustaka</th>
                            <td>Mahasiswa mampu menampilkan teori yang relevan dan dituliskan secara runtun dan lengkap dengan
                                disertai argumentasi ilmiah dari pengusul proposal.</td>
                            <td class="text-center">{{ $pembimbing1->nl_tinjauanpustaka ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Metodologi Penelitian</th>
                            <td>Mahasiswa mampu menentukan metode yang selaras dengan permasalahan dan konsep teori. Detail
                                rancangan penelitian diuraikan dengan runtun setiap tahapan dan dapat diselesaikan sesuai dengan
                                rencana waktu penelitian.</td>
                            <td class="text-center">{{ $pembimbing1->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Penggunaan Bahasa dan Tata Tulis</th>
                            <td>Mahasiswa mampu menyusun naskah proposal menggunakan ejaan bahasa Indonesia yang baik dan benar,
                                serta mengikuti aturan dan panduan penulisan.</td>
                            <td class="text-center">{{ $pembimbing1->nl_bahasadantatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Presentasi</th>
                            <td>Komunikatif, ketepatan waktu, kejelasan, dan keruntunan dalam penyampaian materi.</td>
                            <td class="text-center">{{ $pembimbing1->nl_presentasi ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end"><strong>Rata-rata Nilai</strong></th>
                            <td class="text-center">
                                {{ number_format(
                                    (($pembimbing1->nl_pendahuluan ?? 0) +
                                        ($pembimbing1->nl_tinjauanpustaka ?? 0) +
                                        ($pembimbing1->nl_metodologipenelitian ?? 0) +
                                        ($pembimbing1->nl_bahasadantatatulis ?? 0) +
                                        ($pembimbing1->nl_presentasi ?? 0)) /
                                        5,
                                    2,
                                    '.',
                                    '',
                                ) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td colspan="2">{{ $pembimbing1->komentar ?? 'Tidak ada komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive my-5">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th colspan="2">Pembimbing Dua</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 200px;">Pendahuluan</th>
                            <td>Mahasiswa mampu menjelaskan latar belakang, tujuan, dan kontribusi penelitian.</td>
                            <td class="text-center">{{ $pembimbing2->nl_pendahuluan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tinjauan Pustaka</th>
                            <td>Mahasiswa mampu menampilkan teori yang relevan dan dituliskan secara runtun dan lengkap dengan
                                disertai argumentasi ilmiah dari pengusul proposal.</td>
                            <td class="text-center">{{ $pembimbing2->nl_tinjauanpustaka ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Metodologi Penelitian</th>
                            <td>Mahasiswa mampu menentukan metode yang selaras dengan permasalahan dan konsep teori. Detail
                                rancangan penelitian diuraikan dengan runtun setiap tahapan dan dapat diselesaikan sesuai dengan
                                rencana waktu penelitian.</td>
                            <td class="text-center">{{ $pembimbing2->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Penggunaan Bahasa dan Tata Tulis</th>
                            <td>Mahasiswa mampu menyusun naskah proposal menggunakan ejaan bahasa Indonesia yang baik dan benar,
                                serta mengikuti aturan dan panduan penulisan.</td>
                            <td class="text-center">{{ $pembimbing2->nl_bahasadantatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Presentasi</th>
                            <td>Komunikatif, ketepatan waktu, kejelasan, dan keruntunan dalam penyampaian materi.</td>
                            <td class="text-center">{{ $pembimbing2->nl_presentasi ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end"><strong>Rata-rata Nilai</strong></th>
                            <td class="text-center">
                                {{ number_format(
                                    (($pembimbing2->nl_pendahuluan ?? 0) +
                                        ($pembimbing2->nl_tinjauanpustaka ?? 0) +
                                        ($pembimbing2->nl_metodologipenelitian ?? 0) +
                                        ($pembimbing2->nl_bahasadantatatulis ?? 0) +
                                        ($pembimbing2->nl_presentasi ?? 0)) /
                                        5,
                                    2,
                                    '.',
                                    '',
                                ) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td colspan="2">{{ $pembimbing2->komentar ?? 'Tidak ada komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th colspan="2">Penguji</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 200px;">Pendahuluan</th>
                            <td>Mahasiswa mampu menjelaskan latar belakang, tujuan, dan kontribusi penelitian.</td>
                            <td class="text-center">{{ $penguji->nl_pendahuluan ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tinjauan Pustaka</th>
                            <td>Mahasiswa mampu menampilkan teori yang relevan dan dituliskan secara runtun dan lengkap dengan
                                disertai argumentasi ilmiah dari pengusul proposal.</td>
                            <td class="text-center">{{ $penguji->nl_tinjauanpustaka ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Metodologi Penelitian</th>
                            <td>Mahasiswa mampu menentukan metode yang selaras dengan permasalahan dan konsep teori. Detail
                                rancangan penelitian diuraikan dengan runtun setiap tahapan dan dapat diselesaikan sesuai dengan
                                rencana waktu penelitian.</td>
                            <td class="text-center">{{ $penguji->nl_metodologipenelitian ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Penggunaan Bahasa dan Tata Tulis</th>
                            <td>Mahasiswa mampu menyusun naskah proposal menggunakan ejaan bahasa Indonesia yang baik dan benar,
                                serta mengikuti aturan dan panduan penulisan.</td>
                            <td class="text-center">{{ $penguji->nl_bahasadantatatulis ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Presentasi</th>
                            <td>Komunikatif, ketepatan waktu, kejelasan, dan keruntunan dalam penyampaian materi.</td>
                            <td class="text-center">{{ $penguji->nl_presentasi ?? 'Belum Dinilai' }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-end"><strong>Rata-rata Nilai</strong></th>
                            <td class="text-center">
                                {{ number_format(
                                    (($penguji->nl_pendahuluan ?? 0) +
                                        ($penguji->nl_tinjauanpustaka ?? 0) +
                                        ($penguji->nl_metodologipenelitian ?? 0) +
                                        ($penguji->nl_bahasadantatatulis ?? 0) +
                                        ($penguji->nl_presentasi ?? 0)) /
                                        5,
                                    2,
                                    '.',
                                    '',
                                ) }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Komentar</th>
                            <td colspan="2">{{ $penguji->komentar ?? 'Tidak ada komentar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    @endcan

    @can('isDosen')
        <h2>Data Seminar Proposal</h2>
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sempro as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->semprotugasakhir->tugasakhirmahasiswa->nama }}</td>
                            <td>
                                <a href="/detailsempro/{{ $item->id }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan

    @can('isKaprodi')
        <h2>Data Seminar Proposal</h2>
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sempro as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->semprotugasakhir->tugasakhirmahasiswa->nama }}</td>
                            <td>
                                <a href="/detailsempro/{{ $item->id }}" class="btn btn-info">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endcan

@endsection
