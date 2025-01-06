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
