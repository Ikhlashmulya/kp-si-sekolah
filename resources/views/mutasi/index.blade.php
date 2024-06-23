<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Mutasi Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mutasi Siswa</li>
        </ol>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="date" onchange="this.form.submit()">
                <option value="semua" {{ $filterForView == 'semua' ? 'selected' : '' }}>semua</option>
                @foreach ($dates as $d)
                    <option value="{{ $d['month'] }}" {{ $d['month'] == $filterForView ? 'selected' : '' }}>
                        {{ $d['month'] }}</option>
                @endforeach
            </select>
        </form>

        <div class="card mb-4 mt-5">
            <div class="card-header">
                Mutasi Masuk
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Kelas</th>
                            <th>Tanggal Masuk</th>
                            <th>Asal Sekolah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Kelas</th>
                            <th>Tanggal Masuk</th>
                            <th>Asal Sekolah</th>
                            <th>Keterangan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($mutasiMasuk as $mm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mm->siswa->no_induk }}</td>
                                <td>{{ $mm->siswa->nisn }}</td>
                                <td>{{ $mm->siswa->nama }}</td>
                                <td>{{ $mm->siswa->jenis_kelamin }}</td>
                                <td>{{ $mm->siswa->kelas->nama_kelas }}</td>
                                <td>{{ $mm->tgl_masuk }}</td>
                                <td>{{ $mm->asal_sekolah }}</td>
                                <td>{{ $mm->keterangan }}</td>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div class="card-header">
                Mutasi Keluar
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Kelas</th>
                            <th>Tanggal Keluar</th>
                            <th>Tujuan Sekolah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Kelas</th>
                            <th>Tanggal Keluar</th>
                            <th>Tujuan Sekolah</th>
                            <th>Keterangan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($mutasiKeluar as $mk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mk->siswa->no_induk }}</td>
                                <td>{{ $mk->siswa->nisn }}</td>
                                <td>{{ $mk->siswa->nama }}</td>
                                <td>{{ $mk->siswa->jenis_kelamin }}</td>
                                <td>{{ $mk->siswa->kelas->nama_kelas }}</td>
                                <td>{{ $mk->tgl_keluar }}</td>
                                <td>{{ $mk->tujuan_sekolah }}</td>
                                <td>{{ $mk->keterangan }}</td>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4 mt-2">
            <div class="card-header">
                Rekap
            </div>

            <div class="card-body">
                @if ($rekapMutasi)
                    <div class="d-flex justify-content-between">
                        Bulan : {{ $filterForView }}
                        <a class="btn btn-primary" href="/mutasi/export/{{ $date }}">Export</a>
                    </div>
                    <table id="datatablesSimple" class="table text-center">
                        <thead>
                            <tr>
                                <th rowspan="3">Kelas</th>
                                <th colspan="3" rowspan="2">Awal</th>
                                <th colspan="6">Mutasi</th>
                                <th colspan="3" rowspan="2">Akhir</th>
                            </tr>
                            <tr>
                                <th colspan="3">Masuk</th>
                                <th colspan="3">Keluar</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>JML</th>

                                <th>L</th>
                                <th>P</th>
                                <th>JML</th>

                                <th>L</th>
                                <th>P</th>
                                <th>JML</th>

                                <th>L</th>
                                <th>P</th>
                                <th>JML</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekapMutasi as $data)
                                <tr>
                                    <td>{{ $data['kelas'] }}</td>
                                    <td>{{ $data['awalL'] }}</td>
                                    <td>{{ $data['awalP'] }}</td>
                                    <td>{{ $data['awalJM'] }}</td>
                                    <td>{{ $data['masukL'] }}</td>
                                    <td>{{ $data['masukP'] }}</td>
                                    <td>{{ $data['masukJM'] }}</td>
                                    <td>{{ $data['keluarL'] }}</td>
                                    <td>{{ $data['keluarP'] }}</td>
                                    <td>{{ $data['keluarJM'] }}</td>
                                    <td>{{ $data['akhirL'] }}</td>
                                    <td>{{ $data['akhirP'] }}</td>
                                    <td>{{ $data['akhirJM'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <b>*Pilih tanggal untuk melihat rekap</b>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
