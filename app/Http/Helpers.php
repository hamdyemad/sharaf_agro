<?php

use App\Models\Permession;
use App\Models\Setting;


function activeRoute($routeName) {
    if(Route::current()->getName() == $routeName) {
        return true;
    }
}

function get_setting($type) {
    $setting = Setting::where('type', $type)->first();
    if($setting) {
        return $setting->value;
    } else {
        return null;
    }
}

function permession_maker($name, $key, $groupBy) {
    $permession = Permession::where('key', $key)
    ->where('name', $name)
    ->first();
    if($permession) {
        return null;
    } else {
        Permession::create([
            'name' => $name,
            'key' => $key,
            'group_by' => $groupBy
        ]);
    }
}
