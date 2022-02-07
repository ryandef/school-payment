<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TunggakanExport implements FromView
{

    public function __construct($models, $bulan, $ta)
    {
        $this->models = $models;
        $this->bulan = $bulan;
        $this->ta = $ta;
    }

    public function view(): View
    {
        return view('admin.laporan.tunggakan-export', [
            'models' => $this->models,
            'bulan' => $this->bulan,
            'ta' => $this->ta,
            'tahun_ajaran' => $this->ta,
        ]);
    }
}

