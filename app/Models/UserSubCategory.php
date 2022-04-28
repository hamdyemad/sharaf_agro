<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserSubCategory extends Model
{
    protected $table = 'user_sub_categories';
    protected $fillable = ['user_id', 'sub_category_id'];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }
}
