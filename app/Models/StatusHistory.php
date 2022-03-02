<?php

namespace App\Models;

use App\User;
use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $table = 'statuses_histroy';
    protected $fillable = ['user_id', 'order_id', 'status_id'];
    //

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
