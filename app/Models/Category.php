<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['branch_id','name', 'photo', 'viewed_number', 'active'];

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
