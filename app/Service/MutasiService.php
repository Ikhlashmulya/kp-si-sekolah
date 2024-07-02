<?php

namespace App\Service;

use App\Models\Kelas;
use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MutasiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getMutasiMasuk(string $filter = "semua"): object
    {
        if ($filter === "semua") {
            return MutasiMasuk::all()->map(function ($value) {
                $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
                return $value;
            });
        } else {
            list($month, $year) = explode('-', $filter);

            return MutasiMasuk::whereRaw('strftime(\'%Y\', tgl_masuk) = ?', [$year])->whereRaw('strftime(\'%m\', tgl_masuk) = ?', [$month])->get()->map(function ($value) {
                $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
                return $value;
            });
        }
    }

    public static function getMutasiKeluar(string $filter = "semua"): object
    {
        if ($filter === "semua") {
            return MutasiKeluar::all()->map(function ($value) {
                $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
                return $value;
            });
        } else {
            list($month, $year) = explode('-', $filter);

            return MutasiKeluar::whereRaw('strftime(\'%Y\', tgl_keluar) = ?', [$year])->whereRaw('strftime(\'%m\', tgl_keluar) = ?', [$month])->get()->map(function ($value) {
                $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
                return $value;
            });
        }
    }

    public static function getDates(): array|Collection
    {
        $dateMutasiMasuk = MutasiMasuk::selectRaw('strftime(\'%Y\', tgl_masuk) as year, strftime(\'%m\', tgl_masuk) as month');
        return MutasiKeluar::selectRaw('strftime(\'%Y\', tgl_keluar) as year, strftime(\'%m\', tgl_keluar) as month')
            ->union($dateMutasiMasuk)
            ->distinct()
            ->get()
            ->map(function ($date) {
                return [
                    'year' => $date->year,
                    'month' => Carbon::createFromFormat('!m', $date->month)->translatedFormat('F') . ' ' . $date->year
                ];
            });
    }

    public static function getRekap(string $filter): array|null
    {
        try {
            list($month, $year) = explode('-', $filter);
        } catch (\Throwable $th) {
            return null;
        }

        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $classes = Kelas::all();
        $report = [];

        foreach ($classes as $class) {

            $awalL = $class->siswa()->where('jenis_kelamin', 'L')->whereDate('created_at', '<', $startOfMonth)->count();
            $awalP = $class->siswa()->where('jenis_kelamin', 'P')->whereDate('created_at', '<', $startOfMonth)->count();
            $awalJM = $awalL + $awalP;

            $masukL = $class->mutasiMasuk()->whereBetween('tgl_masuk', [$startOfMonth, $endOfMonth])->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $masukP = $class->mutasiMasuk()->whereBetween('tgl_masuk', [$startOfMonth, $endOfMonth])->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'P');
            })->count();

            $masukJM = $masukL + $masukP;

            $keluarL = $class->mutasiKeluar()->whereBetween('tgl_keluar', [$startOfMonth, $endOfMonth])->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $keluarP = $class->mutasiKeluar()->whereBetween('tgl_keluar', [$startOfMonth, $endOfMonth])->whereHas('siswa', function ($query) {
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

    public static function sumRekapBulanan(array|null $report): array|null {
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
}
