<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'transaction_id','order_id','amount'
    ];


    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
