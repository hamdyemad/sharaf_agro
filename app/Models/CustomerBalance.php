<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CustomerBalance extends Model
{
    protected $table = 'customers_balance';
    protected $fillable = ['user_id', 'balance'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
