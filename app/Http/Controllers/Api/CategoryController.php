<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use Res;
    public function index(Request $request) {
        $categories = Category::latest();
        if($request->name) {
            $categories->where('name', 'like', '%' . $request->name . '%');
        }
        $categories = $categories->get();
        return $this->sendRes('', true, $categories);
    }
}
