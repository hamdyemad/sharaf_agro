<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = 'products_prices';
    protected $fillable = ['product_id', 'currency_id', 'price', 'discount', 'price_after_discount'];

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
