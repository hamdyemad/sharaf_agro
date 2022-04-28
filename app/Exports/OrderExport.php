<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }
    public function view(): View
    {
        return view('orders.export', [
            'orders' => $this->orders
        ]);
    }
}
