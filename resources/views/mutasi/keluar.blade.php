<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Mutasi Keluar Siswa</h1>
        <form action="{{ route('mutasi.keluar') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" value="{{ $siswa->id }}" name="siswa_id" hidden>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ $siswa->nama }}" name="nama" required>
                <label class="form-label">Tujuan Sekolah</label>
                <input type="text" class="form-control" name="tujuan_sekolah" required>
                <label class="form-label">Tanggal Keluar</label>
                <input type="date" class="form-control" name="tgl_keluar" required>
            </div>
            <button type="submit" class="btn btn-danger">Keluarkan</button>
        </form>
    </div>
</x-dashboard-layout>
