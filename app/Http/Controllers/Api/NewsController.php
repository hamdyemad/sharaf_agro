<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\Res;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use Res;
    public function index(Request $request) {
        $news = News::latest();
        if($request->name) {
            $news = $news->where('name','like','%' . $request->name . '%');
        }
        $news = $news->paginate(10);
        return $this->sendRes('', true, $news);
    }
}
