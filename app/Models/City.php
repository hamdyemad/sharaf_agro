<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'country_id'];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function prices() {
        return $this->hasMany(CityPrice::class, 'city_id');
    }

    public function current_price() {
        return $this->hasOne(CityPrice::class, 'city_id');
    }
}
