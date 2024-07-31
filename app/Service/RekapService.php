<?php

namespace App\Service;

use App\Dto\GetMutasiByDateDto;
use App\Models\Kelas;
use Carbon\Carbon;

class RekapService
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getRekapBulanan(GetMutasiByDateDto $requestGetMutasiByDate): array
    {
        $endOfMonth = Carbon::create($requestGetMutasiByDate->year, $requestGetMutasiByDate->month, 1)->endOfMonth();
        $startOfMonth = Carbon::create($requestGetMutasiByDate->year, $requestGetMutasiByDate->month, 1)->startOfMonth();
        $classes = Kelas::all();
        $report = [];

        foreach ($classes as $class) {

            $awalL = $class->siswa()->where('jenis_kelamin', 'L')->whereDate('created_at', '<', $startOfMonth)->count();
            $awalP = $class->siswa()->where('jenis_kelamin', 'P')->whereDate('created_at', '<', $startOfMonth)->count();
            $awalJM = $awalL + $awalP;

            $masukL = $class->mutasiMasuk()->whereDate('tgl_masuk', '>=', $startOfMonth)->whereDate('tgl_masuk', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $masukP = $class->mutasiMasuk()->whereDate('tgl_masuk', '>=', $startOfMonth)->whereDate('tgl_masuk', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'P');
            })->count();

            $masukJM = $masukL + $masukP;

            $keluarL = $class->mutasiKeluar()->whereDate('tgl_keluar', '>=', $startOfMonth)->whereDate('tgl_keluar', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $keluarP = $class->mutasiKeluar()->whereDate('tgl_keluar', '>=', $startOfMonth)->whereDate('tgl_keluar', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'P');
            })->count();

            $keluarJM = $keluarL + $keluarP;

            $akhirL = $awalL + $masukL - $keluarL;
            $akhirP = $awalP + $masukP - $keluarP;
            $akhirJM = $awalJM + $masukJM - $keluarJM;

            $report[] = [
                'kelas' => $class->nama_kelas,
                'awalL' => $awalL,
                'awalP' => $awalP,
                'awalJM' => $awalJM,
                'masukL' => $masukL,
                'masukP' => $masukP,
                'masukJM' => $masukJM,
                'keluarL' => $keluarL,
                'keluarP' => $keluarP,
                'keluarJM' => $keluarJM,
                'akhirL' => $akhirL,
                'akhirP' => $akhirP,
                'akhirJM' => $akhirJM,
            ];
        }

        return $report;
    }

    public static function sumRekapBulanan(array|null $report): array|null
    {
        if (!$report) {
            return null;
        }

        $sum = [
            'jumlahAwalL' => 0,
            'jumlahAwalP' => 0,
            'jumlahAwalJM' => 0,
            'jumlahMasukL' => 0,
            'jumlahMasukP' => 0,
            'jumlahMasukJM' => 0,
            'jumlahKeluarL' => 0,
            'jumlahKeluarP' => 0,
            'jumlahKeluarJM' => 0,
            'jumlahAkhirL' => 0,
            'jumlahAkhirP' => 0,
            'jumlahAkhirJM' => 0,
        ];

        foreach ($report as $value) {
            $sum['jumlahAwalL'] += $value['awalL'];
            $sum['jumlahAwalP'] += $value['awalP'];
            $sum['jumlahAwalJM'] += $value['awalJM'];
            $sum['jumlahMasukL'] += $value['masukL'];
            $sum['jumlahMasukP'] += $value['masukP'];
            $sum['jumlahMasukJM'] += $value['masukJM'];
            $sum['jumlahKeluarL'] += $value['keluarL'];
            $sum['jumlahKeluarP'] += $value['keluarP'];
            $sum['jumlahKeluarJM'] += $value['keluarJM'];
            $sum['jumlahAkhirL'] += $value['akhirL'];
            $sum['jumlahAkhirP'] += $value['akhirP'];
            $sum['jumlahAkhirJM'] += $value['akhirJM'];
        }

        return $sum;
    }

    public static function getRekapTahunan(int $year)
    {
        $startDate = Carbon::create($year, 7, 1);
        $endDate = Carbon::create($year + 1, 6, 30);

        $rekapTahunan = collect();
        $current = $startDate->copy();

        while ($current->lessThanOrEqualTo($endDate)) {
            $rekapTahunan[Carbon::createFromFormat('!m', $current->month)->format('F') . "-" . $current->year] = self::getRekapBulanan(new GetMutasiByDateDto($current->month, $current->year));

            $current->addMonth();
        }

        return $rekapTahunan;
    }
}
