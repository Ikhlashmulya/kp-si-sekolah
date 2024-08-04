<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapBulananExport implements FromView
{

    public function __construct(
        protected object $mutasiMasuk,
        protected object $mutasiKeluar,
        protected array $rekap,
        protected string $date
    ) {
    }

    public function view(): View
    {
        return view('rekap.export-rekap-bulanan', [
            'rekapMutasi' => $this->rekap,
            'date' => $this->date,
            'mutasiMasuk' => $this->mutasiMasuk,
            'mutasiKeluar' => $this->mutasiKeluar
        ]);
    }
}
