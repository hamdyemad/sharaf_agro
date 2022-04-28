<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function sub_categories() {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
