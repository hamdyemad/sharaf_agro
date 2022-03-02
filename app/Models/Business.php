<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = ['branch_id','name', 'type'];

    public function expenses() {
        return $this->hasMany(Expense::class, 'type');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
