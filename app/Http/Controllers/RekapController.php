<?php

namespace App\Http\Controllers;

use App\Dto\GetByDateDto;
use App\Exports\RekapBulananExport;
use App\Exports\RekapTahunanExport;
use App\Service\MutasiService;
use App\Service\RekapService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->input('date', 'noselected');
        $selectedDate = $date;

        $mutasiMasuk = null;
        $mutasiKeluar = null;
        $rekapMutasi = null;
        $rekapTahunan = null;
        $sumRekap = null;

        if ($date !== 'noselected') {
            $date = Carbon::parse($date)->format('m-Y');

            list($month, $year) = explode('-', $date);

            $requestGetByDate = new GetByDateDto($month, $year);
            $mutasiMasuk = MutasiService::getMutasiMasukByDate($requestGetByDate);
            $mutasiKeluar = MutasiService::getMutasiKeluarByDate($requestGetByDate);
            $rekapMutasi = RekapService::getRekapBulanan($requestGetByDate);
            $sumRekap = RekapService::sumRekapBulanan($rekapMutasi);
        }

        $year = $request->input('year', 'noselected');
        // dump($year);
        $selectedYear = $year;
        $rekapTahunan = null;

        if ($year != 'noselected') {
            $rekapTahunan = RekapService::getRekapTahunan($year);
        }

        $dates = MutasiService::getDates();
        $years = MutasiService::getYears();
        // dd($years);


        return view('rekap.index', compact('mutasiMasuk', 'mutasiKeluar', 'dates', 'selectedDate', 'selectedYear', 'rekapMutasi', 'date', 'sumRekap', 'rekapTahunan', 'years'));
    }

    public function exportRekapBulanan(string $date)
    {
        list($month, $year) = explode('-', $date);

        $requestGetByDate = new GetByDateDto($month, $year);
        $mutasiMasuk = MutasiService::getMutasiMasukByDate($requestGetByDate);
        $mutasiKeluar = MutasiService::getMutasiKeluarByDate($requestGetByDate);
        $rekapMutasi = RekapService::getRekapBulanan($requestGetByDate);
        $sumRekap = RekapService::sumRekapBulanan($rekapMutasi);

        $date = Carbon::create($year, $month)->format('F-Y');
        return Excel::download(new RekapBulananExport($mutasiMasuk, $mutasiKeluar, $rekapMutasi, $date, $sumRekap), "rekap-$date.xlsx");
    }

    public function exportRekapTahunan(int $year)
    {
        $rekapTahunan = RekapService::getRekapTahunan($year);

        return Excel::download(new RekapTahunanExport($rekapTahunan), "rekap-$year.xlsx");
    }
}
