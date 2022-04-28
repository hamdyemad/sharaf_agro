<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderView extends Model
{
    protected $table = 'orders_view';
    protected $fillable = [
        'user_id',
        'order_id',
        'viewed'
    ];
}
