<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderUnderWorkExport implements FromView
{
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    public function view(): View
    {
        return view('orders_under_work.export', [
            'orders' => $this->orders
        ]);
    }
}
