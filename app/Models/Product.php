<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','photos','description','price',
        'discount','price_after_discount','active','viewed_number'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
}
