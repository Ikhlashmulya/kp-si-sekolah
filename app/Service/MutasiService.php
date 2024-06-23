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

    public static function getMutasiMasuk(string $filter = "semua"): object {
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

    public static function getMutasiKeluar(string $filter = "semua"): object {
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

    public static function getDates(): array|Collection {
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

            $masukL = $class->mutasiMasuk()->where('tgl_masuk', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $masukP = $class->mutasiMasuk()->where('tgl_masuk', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'P');
            })->count();

            $masukJM = $masukL + $masukP;

            $keluarL = $class->mutasiKeluar()->where('tgl_keluar', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
                $query->where('jenis_kelamin', 'L');
            })->count();

            $keluarP = $class->mutasiKeluar()->where('tgl_keluar', '<=', $endOfMonth)->whereHas('siswa', function ($query) {
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
}
