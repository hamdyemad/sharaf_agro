<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['type', 'branch_id', 'status_id', 'currency_id','user_id','city_id','customer_name',
    'customer_phone', 'customer_address','paid',
    'notes','total_discount', 'shipping','grand_total', 'viewed', 'client_viewed', 'client_status_viewed'];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function order_details() {
        return $this->hasMany(OrderDetail::class);
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    }

}

