<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderUnderWorkHistory extends Model
{
    protected $table = 'orders_under_work_histories';
    protected $fillable = [
        'order_id', 'user_id', 'status_id'
    ];

    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function order()  {
        return $this->belongsTo(OrderUnderWork::class, 'order_id');
    }

    public function status()  {
        return $this->belongsTo(Status::class);
    }
}
