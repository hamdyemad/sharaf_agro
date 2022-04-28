<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUnderWorkView extends Model
{
    protected $table = 'orders_under_work_viewers';
    protected $fillable = [
        'user_id',
        'order_under_work_id',
        'viewed'
    ];
}
