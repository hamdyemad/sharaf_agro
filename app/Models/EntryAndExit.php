<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EntryAndExit extends Model
{
    protected $table = 'entry_and_exit';
    protected $fillable = ['user_id','current_date','entry',
    'exit', 'is_enter' , 'is_exit' , 'latitude', 'longitude'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
