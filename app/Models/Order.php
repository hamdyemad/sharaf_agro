<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'customer_id',
        'employee_id',
        'status_id',
        'name',
        'details',
        'files',
        'submission_date',
        'expected_date',
        'expiry_date',
        'expected_notify'
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
    public function employee() {
        return $this->belongsTo(User::class, 'employee_id');
    }



}
