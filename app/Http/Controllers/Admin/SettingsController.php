<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FirebaseToken;
use App\Models\Inquire;
use App\Models\InquireView;
use App\Models\News;
use App\Models\NewsView;
use App\Models\Order;
use App\Models\OrderUnderWork;
use App\Models\OrderUnderWorkView;
use App\Models\OrderView;
use App\Models\Setting;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\File;
use App\Traits\FirebaseNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function __construct()
    {
    }

    use File, FirebaseNotify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $this->authorize('settings.edit');
        return view('settings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->authorize('settings.edit');
        if($request->logo) {
            $setting = Setting::where('type', 'logo')->first();
            if($setting) {
                if(file_exists($setting->value)) {
                    $img = last(explode('/', $setting->value));
                    if(in_array($img, scandir(dirname($setting->value)))) {
                        unlink($setting->value);
                    }
                }
                $setting->update([
                    'value' => $this->uploadFile($request, $this->settingsPath, 'logo')
                ]);
            } else {
                Setting::create([
                    'type' => 'logo',
                    'value' => $this->uploadFile($request, $this->settingsPath, 'logo')
                ]);
            }
        }
        if($request->has('type')) {
            foreach ($request->type as $key => $value) {
                $setting = Setting::where('type', $key)->first();
                if($setting) {
                    $setting->update(['value' => $value]);
                } else {
                    Setting::create([
                        'type' => $key,
                        'value' => $value
                    ]);
                }
            }
            return redirect()->back()->with('success', 'تم التعديل بنجاح');

        }
    }


    public function show_all_notify(Request $request) {

        // Start Orders
        $orders_view_ids = OrderView::where('user_id', Auth::id())
            ->where('viewed', 1)
            ->pluck('order_id');
        if(Auth::user()->type == 'admin') {
            $orders = Order::whereNotIn('id', $orders_view_ids)
            ->orderBy('updated_at', 'DESC')
            ->get();
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders = Order::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $orders_view_ids)
            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
        } else {
            $orders = Order::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $orders_view_ids)
            ->latest()
            ->get();
        }
        $orders = $orders->pluck('id');


        foreach ($orders as $id) {
            $order_view = OrderView::where('order_id', $id)->where('user_id', Auth::id())->first();
            if($order_view) {
                $order_view->update([
                    'viewed' => 1
                ]);
            } else {
                OrderView::create([
                    'order_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            }
        }
        // End Orders


        // Start News
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
        $news = $news->pluck('id');
        foreach ($news as $id) {
            $new_view = NewsView::where('new_id', $id)->where('user_id', Auth::id())->first();
            if($new_view) {
                $new_view->update([
                    'viewed' => 1
                ]);
            } else {
                NewsView::create([
                    'new_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            }
        }
        // End News


        // Start Order Under Work
        $orders_under_work_ids_views = OrderUnderWorkView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('order_under_work_id');
        if(Auth::user()->type == 'admin') {
            $orders_under_work = OrderUnderWork::whereNotIn('id', $orders_under_work_ids_views)
            ->orderBy('updated_at', 'DESC')
            ->get();
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders_under_work = OrderUnderWork::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $orders_under_work_ids_views)
            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
        } else {
            $orders_under_work = OrderUnderWork::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $orders_under_work_ids_views)
            ->latest()
            ->get();
        }
        $orders_under_work = $orders_under_work->pluck('id');
        foreach ($orders_under_work as $id) {
            $order_under_work_view = OrderUnderWorkView::where('order_under_work_id', $id)->where('user_id', Auth::id())->first();
            if($order_under_work_view) {
                $order_under_work_view->update([
                    'viewed' => 1
                ]);
            } else {
                OrderUnderWorkView::create([
                    'order_under_work_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            }
        }
        // End Order Under Work

        // Start Inquires
        $inquires_ids_view = InquireView::where('user_id', Auth::id())
        ->where('viewed', 1)
        ->pluck('inquire_id');
        if(Auth::user()->type == 'admin') {
            $inquires = Inquire::whereNotIn('id', $inquires_ids_view)
            ->orderBy('updated_at', 'DESC')
            ->get();
        } else if(Auth::user()->type == 'sub-admin') {
            $userCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $userSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $inquires = Inquire::
            whereIn('category_id',$userCategories)
            ->whereNotIn('id', $inquires_ids_view)
            ->whereIn('sub_category_id',$userSubCategories)->latest()->get();
        } else {
            $inquires = Inquire::
            where('customer_id', Auth::id())
            ->whereNotIn('id', $inquires_ids_view)
            ->latest()
            ->get();
        }
        $inquires = $inquires->pluck('id');
        foreach ($inquires as $id) {
            $inquire_view = InquireView::where('inquire_id', $id)->where('user_id', Auth::id())->first();
            if($inquire_view) {
                $inquire_view->update([
                    'viewed' => 1
                ]);
            } else {
                InquireView::create([
                    'inquire_id' => $id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            }
        }
        // End Inquires

        return redirect()->back()->with('success', 'تم التعديل بنجاح');

    }

    public function firebase_tokens(Request $request) {
        $validator = Validator::make($request->all(), [
            'currentToken' => 'required|string'
        ], [
            'currentToken.required' => 'التوكين مطلوب',
            'currentToken.string' => 'التوكين يجب أن يكون نوعه سترينج'
        ]);
        if($validator->fails()) {
            return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
        }
        $firebaseToken = FirebaseToken::where('token', $request->currentToken)->first();
        if(!$firebaseToken) {
            FirebaseToken::create([
                'user_id' => Auth::id(),
                'token' => $request->currentToken
            ]);
            return $this->sendRes('تم انشاء التوكين', true);
        } {
            return "token is created before";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
