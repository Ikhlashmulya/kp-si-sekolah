<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Siswa</li>
        </ol>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah
            Data</button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('siswa.add') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="col-form-label">No Induk:</label>
                                <input type="text" class="form-control" name="no_induk">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">NISN:</label>
                                <input type="text" class="form-control" name="nisn">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control" name="nama">
                            </div>
                            <label class="col-form-label">Jenis Kelamin:</label>
                            <select class="form-select" aria-label="Jenis Kelamin" name="jenis_kelamin">
                                <option value="L">L</option>
                                <option value="P">P</option>
                            </select>
                            <label class="col-form-label">Kelas:</label>
                            <select class="form-select" aria-label="Kelas" name="kelas_id">
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <div class="mt-3">
                                <label class="col-form-label">Asal Sekolah:</label>
                                <input type="text" class="form-control" name="asal_sekolah">
                            </div>
                            <label class="col-form-label">Tanggal masuk:</label>
                            <input type="date" class="form-control datepicker" name="tgl_masuk">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="kelas"
                onchange="this.form.submit()">
                <option value="semua" {{ $filterKelas == 'semua' ? 'selected' : '' }}>semua</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->nama_kelas }}" {{ $k->nama_kelas == $filterKelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </form>

        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>No Induk</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>JK</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($siswa as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->no_induk }}</td>
                                <td>{{ $s->nisn }}</td>
                                <td>{{ $s->nama }}</td>
                                <td>{{ $s->jenis_kelamin }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('siswa.edit', $s) }}">Edit</a>
                                    <a class="btn btn-danger" onclick="return confirm('anda yakin?')" href="{{ route('siswa.keluar', $s)}}">Keluarkan</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
