<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerResponsible extends Model
{
    protected $table = 'customers_responsible';
    protected $fillable = ['user_id','name', 'phone'];
}
