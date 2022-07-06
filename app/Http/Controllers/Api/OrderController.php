<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Status;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\Res;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use Res;
    public function index(Request $request)
    {
        if(
            Auth::user()->type == 'sub-admin' && $this->authorize('orders.index')
            || Auth::user()->type == 'user' || Auth::user()->type == 'admin') {
                $customers = User::where('type', 'user')->get();
                $employees = User::where('type', 'sub-admin')->get();
                if(Auth::user()->type !== 'sub-admin') {
                    $categories = Category::all();
                } else {
                    $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
                    $categories = Category::whereIn('id',$employeeCategories)->get();
                }
                $statuses = Status::whereNotIn('name',['تم القبول', 'رفض', 'معلق'])->orderBy('name')->get();
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
                $orders = $orders->with(['category', 'sub_category', 'customer', 'employee', 'status'])->get();
                $data = [
                    'orders' => $orders,
                    'customers' => $customers,
                    'employees' => $employees,
                    'categories' => $categories,
                    'statuses' => $statuses
                ];
                if(Auth::user()->type !== 'admin') {
                    $data['employees'] = [];
                }
                return $this->sendRes('', true, $data);
            } else {
                return $this->sendRes('ليس لديك صلاحية', false);
            }
    }

    public function alerts_renovations(Request $request) {
        if(
            Auth::user()->type == 'sub-admin' && $this->authorize('orders.alerts.renovations')
            || Auth::user()->type == 'user' || Auth::user()->type == 'admin') {
                if(Auth::user()->type == 'admin') {
                    $orders = Order::orderBy('updated_at', 'DESC')->orderBy('expiry_date', 'DESC')
                    ->whereDate('expiry_date', '<=' ,  Carbon::now()->format('Y-m-d'))
                    ->OrwhereDate('expiry_date_notify', '<=' ,  Carbon::now()->format('Y-m-d'));
                    $orders = $orders->latest();
                } else if(Auth::user()->type == 'sub-admin') {
                    $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
                    $employeeSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                    $orders = Order::orderBy('expiry_date', 'DESC')
                    ->whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)
                    ->whereDate('expiry_date_notify', '<=' ,  Carbon::now()->format('Y-m-d'))

                    ->orWhereDate('expiry_date', '<=' ,  Carbon::now()->format('Y-m-d'))
                    ->whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)

                    ->latest();
                } else if(Auth::user()->type == 'user') {
                    $orders = Order::orderBy('updated_at', 'DESC')->orderBy('expiry_date', 'DESC')
                    ->whereDate('expiry_date', '<=' ,  Carbon::now()->format('Y-m-d'))
                    ->where('customer_id', Auth::id())->latest()

                    ->OrwhereDate('expiry_date_notify', '<=' ,  Carbon::now()->format('Y-m-d'))
                    ->where('customer_id', Auth::id())->latest();
                }
                $orders = $orders->with(['category', 'sub_category', 'customer', 'employee', 'status'])->get();
                return $this->sendRes('تم جلب طلبات التجديدات بنجاح', true, $orders);
        } else {
            return abort(401);
        }
    }
}
