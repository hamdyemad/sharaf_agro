<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquireView extends Model
{
    protected $table = 'inquires_view';
    protected $fillable = [
        'user_id',
        'inquire_id',
        'viewed'
    ];
}
