<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Data Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item">Data Siswa</li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        <form action="{{ route('siswa.update', $siswa) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">No Induk</label>
                <input type="text" class="form-control" value="{{ $siswa->no_induk }}" name="no_induk" required>
                <label class="form-label">NISN</label>
                <input type="text" class="form-control" value="{{ $siswa->nisn }}" name="nisn" required>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ $siswa->nama }}" name="nama" required>
                <label class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin">
                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                </select>
                <label class="form-label">Kelas</label>
                <select class="form-select" name="kelas_id">
                    @foreach ($kelas as $k)
                        <option value="{{ $k->nama_kelas }}" {{ $siswa->kelas_id == $k->nama_kelas ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <label class="col-form-label">Tanggal masuk:</label>
                <input type="date" class="form-control datepicker" name="tgl_masuk"
                    value="{{ $mutasiMasuk->tgl_masuk }}" required>
                <label class="col-form-label">Asal Sekolah:</label>
                <input type="text" class="form-control" name="asal_sekolah" value="{{ $mutasiMasuk->asal_sekolah }}" required>
                <label class="col-form-label">Keterangan Masuk:</label>
                <select class="form-select" aria-label="Jenis Kelamin" name="keterangan">
                    <option value="siswa baru" {{ $mutasiMasuk->keterangan === 'siswa baru' ? 'selected' : '' }}>siswa
                        baru</option>
                    <option value="siswa pindahan"
                        {{ $mutasiMasuk->keterangan === 'siswa pindahan' ? 'selected' : '' }}>
                        siswa pindahan</option>
                    <option value="keluar" {{ $mutasiMasuk->keterangan === 'keluar' ? 'selected' : '' }}>keluar
                    </option>
                    <option value="lulus" {{ $mutasiMasuk->keterangan === 'lulus' ? 'selected' : '' }}>lulus
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
</x-dashboard-layout>
