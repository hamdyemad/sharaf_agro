<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';
    protected $fillable = ['lang_id', 'lang_key', 'lang_value'];

    public function language() {
        return $this->belongsTo(Language::class, 'lang_id');
    }
}
