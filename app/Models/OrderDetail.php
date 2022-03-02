<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orders_details';
    protected $fillable = ['order_id', 'product_id', 'variant','variant_type', 'price', 'qty','total_price'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function variants($type) {
        return $this->where('order_id', $this->order_id)->where('variant_type', $type)->get();
    }
}
