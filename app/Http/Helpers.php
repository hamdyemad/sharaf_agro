<?php

use App\Models\Permession;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

function activeRoute($routeNames) {
    if(is_array($routeNames)) {
        foreach ($routeNames as $routeName) {
            if(Route::currentRouteName() == $routeName) {
                return true;
            }
        }
    } else {
        if(Route::currentRouteName() == $routeNames) {
            return true;
        }
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

function paginate($items, $perPage=5, $page=null, $options = []) {
    $page = $page ? : (Paginator::resolveCurrentPage()) ? : 1;
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}
