<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class InquireHistory extends Model
{
    protected $table = 'inquires_histories';
    protected $fillable = [
        'inquire_id', 'user_id'
    ];

    public function user()  {
        return $this->belongsTo(User::class);
    }
    public function inquire()  {
        return $this->belongsTo(Inquire::class, 'inquire_id');
    }
}
