<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Mutasi Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mutasi Siswa</li>
        </ol>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="kelas" onchange="this.form.submit()">
                {{-- <option value="semua" {{ $filterKelas == 'semua' ? 'selected' : '' }}>semua</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->nama_kelas }}" {{ $k->nama_kelas == $filterKelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}</option>
                @endforeach --}}
                <option>Juni</option>
                <option>Juni</option>
                <option>Juni</option>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-layout>
