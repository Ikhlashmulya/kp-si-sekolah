<?php

namespace App\Service;

use App\Dto\GetMutasiByDateDto;
use App\Models\MutasiKeluar;
use App\Models\MutasiMasuk;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MutasiService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getAllMutasiMasuk(): object
    {
        return MutasiMasuk::all()->map(function ($value) {
            $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
            return $value;
        });
    }

    public static function getMutasiMasukByDate(GetMutasiByDateDto $requestGetMutasiByDate): object
    {
        return MutasiMasuk::whereRaw('strftime(\'%Y\', tgl_masuk) = ?', [$requestGetMutasiByDate->year])->whereRaw('strftime(\'%m\', tgl_masuk) = ?', [$requestGetMutasiByDate->month])->get()->map(function ($value) {
            $value->tgl_masuk = Carbon::parse($value->tgl_masuk)->format('d-F-Y');
            return $value;
        });
    }

    public static function getAllMutasiKeluar(): object
    {
        return MutasiKeluar::all()->map(function ($value) {
            $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
            return $value;
        });
    }

    public static function getMutasiKeluarByDate(GetMutasiByDateDto $requestGetMutasiByDate): object
    {
        return MutasiKeluar::whereRaw('strftime(\'%Y\', tgl_keluar) = ?', [$requestGetMutasiByDate->year])->whereRaw('strftime(\'%m\', tgl_keluar) = ?', [$requestGetMutasiByDate->month])->get()->map(function ($value) {
            $value->tgl_keluar = Carbon::parse($value->tgl_keluar)->format('d-F-Y');
            return $value;
        });
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
}
