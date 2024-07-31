<?php

namespace App\Http\Controllers;

use App\Dto\GetMutasiByDateDto;
use App\Exports\RekapExport;
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
        $selected = $date;

        $mutasiMasuk = null;
        $mutasiKeluar = null;
        $rekapMutasi = null;

        if ($date !== 'noselected') {
            $date = Carbon::parse($date)->format('m-Y');

            list($month, $year) = explode('-', $date);

            $requestGetMutasiByDate = new GetMutasiByDateDto($month, $year);
            $mutasiMasuk = MutasiService::getMutasiMasukByDate($requestGetMutasiByDate);
            $mutasiKeluar = MutasiService::getMutasiKeluarByDate($requestGetMutasiByDate);
            $rekapMutasi = RekapService::getRekapBulanan($requestGetMutasiByDate);
        } else {
            $mutasiMasuk = MutasiService::getAllMutasiMasuk();
            $mutasiKeluar = MutasiService::getAllMutasiKeluar();
        }

        $sumRekap = RekapService::sumRekapBulanan($rekapMutasi);
        $dates = MutasiService::getDates();
        $rekapTahunan = RekapService::getRekapTahunan(2024);


        return view('rekap.index', compact('mutasiMasuk', 'mutasiKeluar', 'dates', 'selected', 'rekapMutasi', 'date', 'sumRekap', 'rekapTahunan'));
    }

    public function exportRekapBulanan(string $date)
    {
        list($month, $year) = explode('-', $date);

        $requestGetMutasiByDate = new GetMutasiByDateDto($month, $year);
        $mutasiMasuk = MutasiService::getMutasiMasukByDate($requestGetMutasiByDate);
        $mutasiKeluar = MutasiService::getMutasiKeluarByDate($requestGetMutasiByDate);
        $rekapMutasi = RekapService::getRekapBulanan($requestGetMutasiByDate);

        $date = Carbon::create($year, $month)->format('F-Y');
        return Excel::download(new RekapExport($mutasiMasuk, $mutasiKeluar, $rekapMutasi, $date), "rekap-$date.xlsx");
    }
}
