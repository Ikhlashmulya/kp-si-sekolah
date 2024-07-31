<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Mutasi Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mutasi Siswa</li>
        </ol>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="date" onchange="this.form.submit()">
                <option value="noselected" {{ $selected == '' ? 'selected' : '' }}>---</option>
                @foreach ($dates as $d)
                    <option value="{{ $d['month'] }}" {{ $d['month'] == $selected ? 'selected' : '' }}>
                        {{ $d['month'] }}</option>
                @endforeach
            </select>
        </form>

        <div class="card mb-4 mt-2">
            <div class="card-header">
                Rekap Bulanan
            </div>

            <div class="card-body">
                @if ($rekapMutasi && $sumRekap)
                    <div class="d-flex justify-content-between">
                        Bulan : {{ $selected }}
                        <a class="btn btn-primary" href="/rekap/bulanan/export/{{ $date }}">Export</a>
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
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>{{ $sumRekap['jumlahAwalL'] }}</td>
                                <td>{{ $sumRekap['jumlahAwalP'] }}</td>
                                <td>{{ $sumRekap['jumlahAwalJM'] }}</td>
                                <td>{{ $sumRekap['jumlahMasukL'] }}</td>
                                <td>{{ $sumRekap['jumlahMasukP'] }}</td>
                                <td>{{ $sumRekap['jumlahMasukJM'] }}</td>
                                <td>{{ $sumRekap['jumlahKeluarL'] }}</td>
                                <td>{{ $sumRekap['jumlahKeluarP'] }}</td>
                                <td>{{ $sumRekap['jumlahKeluarJM'] }}</td>
                                <td>{{ $sumRekap['jumlahAkhirL'] }}</td>
                                <td>{{ $sumRekap['jumlahAkhirP'] }}</td>
                                <td>{{ $sumRekap['jumlahAkhirJM'] }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <b>*Pilih tanggal untuk melihat rekap</b>
                @endif
            </div>
        </div>

        <div class="card mb-4 mt-2">
            <div class="card-header">
                Rekap Tahunan
            </div>
            <table id="datatablesSimple" class="table text-center">
                <thead>
                    <tr>
                        <th rowspan="3">Bulan</th>
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
                    @foreach ($rekapTahunan as $key => $value)
                        @foreach ($value as $v)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $v['kelas'] }}</td>
                                <td>{{ $v['awalL'] }}</td>
                                <td>{{ $v['awalP'] }}</td>
                                <td>{{ $v['awalJM'] }}</td>
                                <td>{{ $v['masukL'] }}</td>
                                <td>{{ $v['masukP'] }}</td>
                                <td>{{ $v['masukJM'] }}</td>
                                <td>{{ $v['keluarL'] }}</td>
                                <td>{{ $v['keluarP'] }}</td>
                                <td>{{ $v['keluarJM'] }}</td>
                                <td>{{ $v['akhirL'] }}</td>
                                <td>{{ $v['akhirP'] }}</td>
                                <td>{{ $v['akhirJM'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard-layout>
