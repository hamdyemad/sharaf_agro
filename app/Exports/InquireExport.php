<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InquireExport implements FromView
{
    protected $inquires;
    public function __construct($inquires)
    {
        $this->inquires = $inquires;
    }
    public function view(): View
    {
        return view('inquires.export', [
            'inquires' => $this->inquires
        ]);
    }
}
