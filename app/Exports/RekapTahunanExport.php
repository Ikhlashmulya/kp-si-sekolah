<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class RekapTahunanExport implements FromView
{

    public function __construct(
        protected Collection $rekap
    ) {
    }

    public function view(): View
    {
        return view('rekap.export-rekap-tahunan', [
            'rekapTahunan' => $this->rekap,
        ]);
    }
}
