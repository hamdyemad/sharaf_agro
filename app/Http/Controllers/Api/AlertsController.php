<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquire;
use App\Models\InquireView;
use App\Models\News;
use App\Models\NewsView;
use App\Models\Order;
use App\Models\OrderUnderWork;
use App\Models\OrderUnderWorkView;
use App\Models\OrderView;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\Res;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertsController extends Controller
{

    use Res;
    // News
    public function news() {
        $news_ids_view = NewsView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('new_id');
        if(Auth::user()->type == 'admin') {
            $news = News::whereNotIn('id', $news_ids_view)
            ->orderBy('updated_at', 'DESC')
            ->get();
        } else if(Auth::user()->type == 'sub-admin') {
            $news = News::
            whereNotIn('id', $news_ids_view)->latest()->get();
        } else {
            $news = News::whereNotIn('id', $news_ids_view)
            ->latest()
            ->get();
        }
        return $this->sendRes('تم جلب الأخبار', true, $news);
    }
    // News Seen
    public function news_seen($id) {
        $new = News::find($id);
        if($new) {
            $new_view = NewsView::
            where('new_id', $id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$new_view) {
                NewsView::create([
                    'new_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            } else {
                $new_view->update([
                    'viewed' => 1
                ]);
            }
            return $this->sendRes('تم الرؤية بنجاح', true);
        } else {
            return $this->sendRes('الخبر غير موجود', false);
        }
    }


    // Orders
    public function orders() {
        $orders_view_ids = OrderView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('order_id');
        if(Auth::user()->type == 'admin') {
            $orders = Order::whereNotIn('id', $orders_view_ids)
            ->orderBy('updated_at', 'DESC');
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders = Order::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $orders_view_ids)
            ->whereIn('sub_category_id',$userSubCategories)->latest();
        } else {
            $orders = Order::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $orders_view_ids)
            ->latest();
        }
        $orders = $orders->with(['category', 'sub_category', 'customer', 'employee', 'status'])->get();
        return $this->sendRes('تم جلب الطلبات', true, $orders);
    }
    // Orders Seen
    public function orders_seen($id) {
        $order = Order::find($id);
        if($order) {
            $order_view = OrderView::
            where('order_id', $id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$order_view) {
                OrderView::create([
                    'order_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            } else {
                $order_view->update([
                    'viewed' => 1
                ]);
            }
            return $this->sendRes('تم الرؤية بنجاح', true);
        } else {
            return $this->sendRes('الطلب غير موجود', false);
        }
    }

    // Orders Under Work
    public function orders_under_work() {
        $orders_under_work_ids_views = OrderUnderWorkView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('order_under_work_id');
        if(Auth::user()->type == 'admin') {
            $orders_under_work = OrderUnderWork::whereNotIn('id', $orders_under_work_ids_views)
            ->orderBy('updated_at', 'DESC');
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders_under_work = OrderUnderWork::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $orders_under_work_ids_views)
            ->whereIn('sub_category_id',$userSubCategories)->latest();
        } else {
            $orders_under_work = OrderUnderWork::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $orders_under_work_ids_views)
            ->latest();
        }
        $orders_under_work = $orders_under_work->with(['category', 'sub_category', 'customer', 'status'])->get();
        return $this->sendRes('تم جلب الرسائل', true, $orders_under_work);
    }
    // Orders Under Work Seen
    public function orders_under_work_seen($id) {
        $order_under_work = OrderUnderWork::find($id);
        if($order_under_work) {
            $order_under_work_view = OrderUnderWorkView::
            where('order_under_work_id', $id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$order_under_work_view) {
                OrderUnderWorkView::create([
                    'order_under_work_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            } else {
                $order_under_work_view->update([
                    'viewed' => 1
                ]);
            }
            return $this->sendRes('تم الرؤية بنجاح', true);
        } else {
            return $this->sendRes('الرسالة غير موجودة', false);
        }
    }

    // Inquires
    public function inquires() {
        $inquires_ids_view = InquireView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('inquire_id');
        if(Auth::user()->type == 'admin') {
            $inquires = Inquire::whereNotIn('id', $inquires_ids_view)
            ->orderBy('updated_at', 'DESC');
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $inquires = Inquire::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $inquires_ids_view)
            ->whereIn('sub_category_id',$userSubCategories)->latest();
        } else {
            $inquires = Inquire::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $inquires_ids_view)
            ->latest();
        }

        $inquires = $inquires->with(['category', 'sub_category', 'customer'])->get();

        return $this->sendRes('تم جلب الأستفسارات', true, $inquires);

    }

    // Inquires Seen
    public function inquire_seen($id) {
        $inquire = Inquire::find($id);
        if($inquire) {
            $inquire_view = InquireView::
            where('inquire_id', $id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$inquire_view) {
                InquireView::create([
                    'inquire_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            } else {
                $inquire_view->update([
                    'viewed' => 1
                ]);
            }
            return $this->sendRes('تم الرؤية بنجاح', true);
        } else {
            return $this->sendRes('الأستفسار غير موجود', false);
        }
    }




}
