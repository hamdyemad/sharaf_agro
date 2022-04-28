<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Traits\Res;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use Res;
    public function index(Request $request) {
        $sub_categories = SubCategory::latest();
        if($request->name) {
            $sub_categories->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->category_id) {
            $sub_categories->where('category_id', $request->category_id);
        }
        $sub_categories = $sub_categories->paginate(10);
        return $this->sendRes('', true, $sub_categories);
    }
}
