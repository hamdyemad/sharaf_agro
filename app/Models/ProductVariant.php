<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'products_variations';
    protected $fillable = ['type', 'variant', 'product_id'];

    public function prices() {
        return $this->hasMany(ProductVariantPrice::class, 'variant_id');
    }
}
