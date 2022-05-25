<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'orders_histories';
    protected $fillable = [
        'order_id', 'user_id', 'status_id'
    ];

    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function order()  {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function status()  {
        return $this->belongsTo(Status::class);
    }
}
