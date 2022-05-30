<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EntryAndExitExport implements FromView
{

    protected $entriesAndExits;
    public function __construct($entriesAndExits)
    {
        $this->entriesAndExits = $entriesAndExits;
    }
    public function view(): View
    {
        return view('entry_and_exit.export', [
            'entriesAndExits' => $this->entriesAndExits
        ]);
    }
}
