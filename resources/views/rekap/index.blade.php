<x-dashboard-layout>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Mutasi Siswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active">Data Mutasi Siswa</li>
        </ol>

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="date" onchange="this.form.submit()">
                <option value="noselected" {{ $selectedDate == '' ? 'selected' : '' }}>---</option>
                @foreach ($dates as $d)
                    <option value="{{ $d['month'] }}" {{ $d['month'] == $selectedDate ? 'selected' : '' }}>
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
                        Bulan : {{ $selectedDate }}
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

        <form method="GET">
            <select class="form-select" aria-label="Default select example" name="year"
                onchange="this.form.submit()">
                <option value="noselected" {{ $selectedYear == '' ? 'selected' : '' }}>---</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }} - {{ $year + 1 }}</option>
                @endforeach
            </select>
        </form>

        <div class="card mb-4 mt-2">
            <div class="card-header">
                Rekap Tahunan
            </div>

            <div class="card-body">
                @if ($rekapTahunan)
                    <div class="d-flex justify-content-between">
                        Tahun : {{ $selectedYear }}
                        <a class="btn btn-primary" href="/rekap/tahunan/export/{{ $selectedYear }}">Export</a>
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
                            @foreach ($rekapTahunan as $month => $records)
                                @foreach ($records as $index => $record)
                                    <tr>
                                        @if ($index == 0)
                                            <td rowspan="{{ count($records) }}"> {{ $month }}</td>
                                        @endif
                                        <td>{{ $record['kelas'] }}</td>
                                        <td>{{ $record['awalL'] }}</td>
                                        <td>{{ $record['awalP'] }}</td>
                                        <td>{{ $record['awalJM'] }}</td>
                                        <td>{{ $record['masukL'] }}</td>
                                        <td>{{ $record['masukP'] }}</td>
                                        <td>{{ $record['masukJM'] }}</td>
                                        <td>{{ $record['keluarL'] }}</td>
                                        <td>{{ $record['keluarP'] }}</td>
                                        <td>{{ $record['keluarJM'] }}</td>
                                        <td>{{ $record['akhirL'] }}</td>
                                        <td>{{ $record['akhirP'] }}</td>
                                        <td>{{ $record['akhirJM'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <b>*Pilih tahun untuk melihat rekap tahunan</b>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
