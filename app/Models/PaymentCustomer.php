<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCustomer extends Model
{
    protected $table = 'payment_customers';
    protected $fillable = ['user_id','customer_id','customer_name','customer_phone','customer_city','customer_country','payment_integration'];
}
