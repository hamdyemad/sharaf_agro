<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'products_variations';
    protected $fillable = ['type', 'variant', 'price', 'product_id', 'discount', 'price_after_discount'];
}
