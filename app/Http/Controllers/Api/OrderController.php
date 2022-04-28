<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Status;
use App\Models\UserCategory;
use App\Traits\Res;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use Res;
    public function index(Request $request) {
        if(Auth::user()->type == 'admin') {
            $orders = Order::latest();
        } else if(Auth::user()->type == 'sub-admin') {
            $orders = Order::where('employee_id', Auth::id())->latest();
        } else if(Auth::user()->type == 'user') {
            $orders = Order::where('customer_id', Auth::id())->latest();
        }
        if($request->employee_id) {
            $orders->where('employee_id', $request->employee_id);
        }
        if($request->name) {
            $orders->where('name', 'like', '%'. $request->name . '%');
        }
        if($request->customer_id) {
            $orders->where('customer_id', $request->customer_id);
        }
        if($request->status_id) {
            $orders->where('status_id', $request->status_id);
        }
        if($request->category_id) {
            $orders->where('category_id', $request->category_id);
        }
        if($request->sub_category_id) {
            $orders->where('sub_category_id', $request->sub_category_id);
        }
        if($request->from) {
            $orders->whereDate('created_at', '>=', $request->from);
        }
        if($request->to) {
            $orders->whereDate('created_at', '<=', $request->to);
        }
        if($request->from && $request->to) {
            $orders
            ->whereDate('created_at', '<=', $request->to)
            ->whereDate('created_at', '>=', $request->from);
        }
        $orders = $orders->paginate(10);
        return $this->sendRes('', true, $orders);
    }
}
