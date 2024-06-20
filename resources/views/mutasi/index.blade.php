<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Mutasi Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mutasi Siswa</li>
        </ol>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="kelas" onchange="this.form.submit()">
                @foreach ($distinctMonthsAndYears as $m)
                    <option value="{{ $m['month'] }}">
                        {{ $m['month'] }}</option>

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
                            <th>Tanggal Masuk</th>
                            <th>Asal Sekolah</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Tanggal Masuk</th>
                            <th>Asal Sekolah</th>
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
                                <td>{{ $mm->tgl_masuk }}</td>
                                <td>{{ $mm->asal_sekolah }}</td>
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
                            <th>Tanggal Keluar</th>
                            <th>Tujuan Sekolah</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Tanggal Keluar</th>
                            <th>Tujuan Sekolah</th>
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
                                <td>{{ $mk->tgl_keluar }}</td>
                                <td>{{ $mk->tujuan_sekolah }}</td>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
