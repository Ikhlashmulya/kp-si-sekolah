<?php

namespace App\Service;

use App\Dto\GetByDateDto;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RekapService
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getRekapBulanan(GetByDateDto $requestGetByDate): array
    {
        $endOfMonth = Carbon::create($requestGetByDate->year, $requestGetByDate->month, 1)->endOfMonth();
        $startOfMonth = Carbon::create($requestGetByDate->year, $requestGetByDate->month, 1)->startOfMonth();
        $classes = Kelas::all();
        $report = [];

        foreach ($classes as $class) {
            $resultQueryForJmlAwal = DB::select("
                SELECT
                    SUM(CASE WHEN siswa.jenis_kelamin = 'L' THEN 1 ELSE 0 END) AS L_awal,
                    SUM(CASE WHEN siswa.jenis_kelamin = 'P' THEN 1 ELSE 0 END) AS P_awal,
                    COUNT(*) AS JML_awal
                FROM siswa
                JOIN kelas ON siswa.kelas_id = kelas.nama_kelas
                WHERE siswa.deleted_at IS NULL
                AND strftime('%Y-%m', created_at) < ?
                AND kelas.nama_kelas = ?
            ", ["$requestGetByDate->year"."-"."$requestGetByDate->month", $class->nama_kelas]);

            $awalL = $resultQueryForJmlAwal[0]->L_awal === null ? 0 : $resultQueryForJmlAwal[0]->L_awal;
            $awalP = $resultQueryForJmlAwal[0]->P_awal === null ? 0 : $resultQueryForJmlAwal[0]->P_awal;
            $awalJM = $resultQueryForJmlAwal[0]->JML_awal;

            //     $awalL = $class->siswa()->where('jenis_kelamin', 'L')->whereDate('created_at', '<', $startOfMonth)->count();
            //     $awalP = $class->siswa()->where('jenis_kelamin', 'P')->whereDate('created_at', '<', $startOfMonth)->count();
            //     $awalJM = $awalL + $awalP;

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

    public static function getRekapTahunan(int $yearRequest)
    {
        $startDate = Carbon::create($yearRequest, 7, 1);
        $endDate = Carbon::create($yearRequest + 1, 6, 30);

        $rekapTahunan = collect();
        $current = $startDate->copy();

        while ($current->lessThanOrEqualTo($endDate)) {
            list($month, $year) = explode('-', $current->format('m-Y'));
            $rekapTahunan[Carbon::createFromFormat('!m', $current->month)->format('F') . "-" . $current->year] = self::getRekapBulanan(new GetByDateDto($month, $year));

            $current->addMonth();
        }

        return $rekapTahunan;
    }
}
