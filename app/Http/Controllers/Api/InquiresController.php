<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inquire;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiresController extends Controller
{
    use Res;
    public function index(Request $request) {
        if(Auth::user()->type == 'user') {
            $inquires = Inquire::where('customer_id', Auth::id())->latest();
        } else if(Auth::user()->type == 'sub-admin') {
            $user_categories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $user_sub_categories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $inquires = Inquire::
            whereIn('category_id', $user_categories)
            ->whereIn('sub_category_id', $user_sub_categories)
            ->latest();
        } else {
            $inquires = Inquire::latest();
        }
        if($request->details) {
            $inquires->where('details', 'like', '%'. $request->details . '%');
        }
        if($request->customer_id) {
            $inquires->where('customer_id', $request->customer_id);
        }
        if($request->status_id) {
            $inquires->where('status_id', $request->status_id);
        }
        if($request->category_id) {
            $inquires->where('category_id', $request->category_id);
        }
        if($request->sub_category_id) {
            $inquires->where('sub_category_id', $request->sub_category_id);
        }
        $inquires = $inquires->paginate(10);
        return $this->sendRes('', true, $inquires);
    }
}
