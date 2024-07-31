<p>Rekap {{ $date }}</p>
<table>
    <tr>
        <td rowspan="3">Kelas</td>
        <td colspan="3" rowspan="2">Awal</td>
        <td colspan="6">Mutasi</td>
        <td colspan="3" rowspan="2">Akhir</td>
    </tr>
    <tr>
        <td colspan="3">Masuk</td>
        <td colspan="3">Keluar</td>
    </tr>
    <tr>
        <td>L</td>
        <td>P</td>
        <td>JML</td>

        <td>L</td>
        <td>P</td>
        <td>JML</td>

        <td>L</td>
        <td>P</td>
        <td>JML</td>

        <td>L</td>
        <td>P</td>
        <td>JML</td>
    </tr>
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
    <tr>
        <td colspan="13"> </td>
    </tr>
    <tr>
        <td colspan="9">Mutasi Masuk</td>
    </tr>
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
    <tr>
        <td colspan="13"> </td>
    </tr>
    <tr>
        <td colspan="9">Mutasi Keluar</td>
    </tr>
    <tr>
        <th>No</th>
        <th>No Induk</th>
        <th>NISN</th>
        <th >Nama Lengkap</th>
        <th>JK</th>
        <th>Kelas</th>
        <th>Tanggal Keluar</th>
        <th >Tujuan Sekolah</th>
        <th>Keterangan</th>
    </tr>
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
</table>
