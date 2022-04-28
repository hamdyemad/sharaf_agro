<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OrderUnderWork extends Model
{
    protected $table = 'orders_under_work';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'customer_id',
        'status_id',
        'name',
        'details',
        'files',
        'reason',
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
