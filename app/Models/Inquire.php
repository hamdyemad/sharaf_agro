<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Inquire extends Model
{
    protected $table = 'inquiries';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'customer_id',
        'status_id',
        'details',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
