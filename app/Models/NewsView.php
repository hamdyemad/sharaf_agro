<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    protected $table = 'news_view';
    protected $fillable = [
        'user_id',
        'new_id',
        'viewed'
    ];
}
