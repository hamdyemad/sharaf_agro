<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = [
        'name', 'phone', 'address'
    ];

    public function bussinesses() {
        return $this->hasMany(Business::class, 'branch_id');
    }

    public function categories() {
        return $this->hasMany(Category::class, 'branch_id');
    }
}
