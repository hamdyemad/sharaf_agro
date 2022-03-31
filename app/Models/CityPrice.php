<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityPrice extends Model
{
    protected $table = 'cities_prices';
    protected $fillable = ['city_id', 'currency_id', 'price'];

    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
