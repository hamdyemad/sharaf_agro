<?php

namespace App\Exports;

use App\Models\CustomerBalance;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class CustomerBalanceExport implements FromView
{

    protected $balances;
    public function __construct($balances)
    {
        $this->balances = $balances;
    }
    public function view(): View
    {
        return view('users.customers.balances.export', [
            'balances' => $this->balances
        ]);
    }
}
