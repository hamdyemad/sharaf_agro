<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permession extends Model
{
    protected $fillable = ['name', 'key','group_by'];
}
