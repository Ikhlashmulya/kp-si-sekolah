<x-dashboard-layout>

    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Kelas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Kelas</li>
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
                    <form action="{{ route('kelas.add') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Nama Kelas:</label>
                                <input type="text" class="form-control" name="nama-kelas" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <b>Nama Kelas</b>
                            </th>
                            <th>L</th>
                            <th>P</th>
                            <th>jumlah Siswa</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kelas as $d)
                            <tr>
                                <td>{{ $d->nama_kelas }}</td>
                                <td>{{ $d->laki_laki }}</td>
                                <td>{{ $d->perempuan }}</td>
                                <td>{{ $d->laki_laki + $d->perempuan }}</td>
                                <td>
                                    <a href="/kelas/delete?nama-kelas={{ $d->nama_kelas }}" class="btn btn-danger" onclick="return confirm('anda yakin?')">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
