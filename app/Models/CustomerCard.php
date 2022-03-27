<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCard extends Model
{
    protected $table = 'customer_cards';
    protected $fillable = [
        'user_id','customer_id','card_id','card_last_4','brand','exp_month','exp_year'
    ];
}
