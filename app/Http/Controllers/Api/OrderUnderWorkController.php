<?php

namespace App\Http\Controllers\Api;

use App\Events\RealOrderUnderWork;
use App\Http\Controllers\Controller;
use App\Mail\SendOrderUnderWork;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderUnderWork;
use App\Models\OrderUnderWorkView;
use App\Models\Status;
use App\Models\SubCategory;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\File;
use App\Traits\Res;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderUnderWorkController extends Controller
{

    use File, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = User::where('type', 'user')->get();
        $statuses = Status::whereIn('name', ['تم القبول', 'رفض', 'معلق'])->orderBy('name')->get();
        if(Auth::user()->type == 'user') {
            $orders = OrderUnderWork::where('customer_id', Auth::id())->latest();
        } else if(Auth::user()->type == 'sub-admin' && Auth::user()->can('orders_under_work.index') == true) {
            $user_categories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $user_sub_categories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders = OrderUnderWork::
            whereIn('category_id', $user_categories)
            ->whereIn('sub_category_id', $user_sub_categories)
            ->latest();
        } else if(Auth::user()->type == 'admin') {
            $orders = OrderUnderWork::latest();
        } else {
            return $this->sendRes('ليس لديك صلاحية', false);
        }
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'user') {
            $categories = Category::all();
        } else {
            $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $categories = Category::whereIn('id',$employeeCategories)->get();
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
        $orders = $orders->paginate(10);
        $data = [
            'orders' => $orders,
            'categories' =>  $categories,
            'statuses' => $statuses,
            'customers' => $customers
        ];
        if(Auth::user()->type == 'user') {
            unset($data['customers']);
        }
        return $this->sendRes('', true, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->type == 'user') {
            $status = Status::where('name', 'معلق')->first();
            $creation = [
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'customer_id' => Auth::id(),
                'status_id' => $status->id,
                'name' => $request->name,
                'details' => $request->details,
            ];
            if($status) {
                $rules = [
                    'category_id' => 'required|exists:categories,id|max:255',
                    'name' => 'required|string|max:255',
                    'details' => 'required|string',
                    'files.*' => ['mimes:pdf,jpg,jpeg,bmp,png', 'file', 'max:5120'],
                    'files' => 'required|max:3'
                ];
                $messages = [
                    'category_id.required' => 'القسم الرئيسى مطلوب',
                    'category_id.exists' => 'القسم الرئيسى غير موجود',
                    'name.required' => 'أسم المركب مطلوب',
                    'name.string' => 'أسم المركب يجب أن يكون من نوع string',
                    'name.max' => 'أسم المركب يجب أن يكون أقل من 255 حرف',
                    'details.required' => 'تفاصيل المركب مطلوبة',
                    'details.string' => 'تفاصيل المركب يجب أن يكون من نوع string',
                    'files.*.required' => ' المرفقات مطلوبة',
                    'files.*.mimes' => 'صيغة الملفات يجب أن تكون pdf,jpg,png,webp',
                    'files.*.max' => ' المرفقات يجب أن يكون حجمها أقل من 5 ميجا',
                    'files.required' => 'المرفقات مطلوبة',
                    'files.max' => 'المرفقات يجب أن تكون أقل من 3',

                ];
                $subs = SubCategory::where('category_id', $request['category_id'])->get();
                if($subs->count() > 0) {
                    $rules['sub_category_id'] = 'required|exists:sub_categories,id';
                    $messages['sub_category_id.required'] = 'الصنف الفرعى مطلوب';
                    $messages['sub_category_id.exists'] = 'الصنف الفرعى غير موجود';
                }
                $validator = Validator::make($request->all(), $rules, $messages);
                if($validator->fails()) {
                    return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
                }
                if($request['files']) {
                    foreach ($request->file('files') as $file) {
                        $files[] = $this->uploadFiles($file, $this->ordersUnderWorkPath);
                    }
                    $creation['files'] = json_encode($files);
                }
                $main_category = Category::find($request->category_id);
                $order_under_work = OrderUnderWork::create($creation);
                $data = [
                    'name' => $request->name,
                    'customer_name' => $order_under_work->customer->name,
                    'status_name' => $status->name,
                    'category_name' => $main_category->name,
                    'details' => $request->details,
                    'subject' => $order_under_work->customer->name . 'رسالة طلب جديد من'
                ];
                $passedDataOfRealTime = [
                    'order' => $order_under_work,
                    'customer_name' => $order_under_work->customer->name,
                    'main_category' => $order_under_work->category->name,
                    'sub_category' => '',
                    'status' => $status->name,
                ];
                if($request->sub_category_id) {
                    $sub_category_name = $order_under_work->category->sub_categories->find($request->sub_category_id)->name;
                    $passedDataOfRealTime['sub_category'] = $sub_category_name;
                }
                // Send Mails
                if($main_category->sub_categories->count() == 0) {
                    $userCategories = UserCategory::where('category_id', $request->category_id)->get();
                    if($userCategories->count() > 0) {
                        // send notification all users had works with this category
                        foreach ($userCategories as $userCategory) {
                            try {
                                Mail::to($userCategory->user->email)->send(new SendOrderUnderWork($data));
                            } catch (\Throwable $th) {
                                    throw $th;
                            }
                        }
                    }
                }
                if($request->sub_category_id) {
                    $data['sub_category_name'] = SubCategory::find($request->sub_category_id)->name;
                    $userSubCategories = UserSubCategory::where('sub_category_id', $request->sub_category_id)->get();
                    if($userSubCategories->count() > 0) {
                        foreach ($userSubCategories as $userSubCategory) {
                        // send notification all users had works with this sub categories
                            try {
                                Mail::to($userSubCategory->user->email)->send(new SendOrderUnderWork($data));
                            } catch (\Throwable $th) {
                                throw $th;
                            }
                        }
                    }
                }
                $admin = User::where('type', 'admin')->first();
                // send Mail to admin
                if($admin->email) {
                    try {
                        Mail::to(User::where('type', 'admin')->first()->email)->send(new SendOrderUnderWork($data));
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
                // Send Push notification to browser
                try {
                    event(new RealOrderUnderWork($passedDataOfRealTime));
                    // Send Mail To Customer of this order under work
                    Mail::to($order_under_work->customer->email)->send(new SendOrderUnderWork($data));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return $this->sendRes('تم انشاء الرسالة بنجاح', true);
            } else {
                return $this->sendRes('الحالة غير موجودة');
            }
        } else {
            return $this->sendRes('الشركات فقط من يستطعون انشاء رسائل الطلبات');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = OrderUnderWork::find($id);
        if($order) {
            if(Auth::user()->type == 'user' || Auth::user()->can('orders_under_work.show')) {
                $pdfs = [];
                $images = [];
                $order_view = OrderUnderWorkView::
                where('order_under_work_id', $order->id)
                ->where('user_id', Auth::id())
                ->first();
                if(!$order_view) {
                    OrderUnderWorkView::create([
                        'order_under_work_id' => $order->id,
                        'user_id' => Auth::id(),
                        'viewed' => 1
                    ]);
                } else {
                    $order_view->update([
                        'viewed' => 1
                    ]);
                }
                if($order->files) {
                    foreach (json_decode($order->files) as $file) {
                        if(strrchr($file,'.') == '.pdf') {
                            array_push($pdfs, $file);
                        } else {
                            array_push($images, $file);
                        }
                    }
                }
                return $this->sendRes('', true, [
                    'order' => $order,
                    'pdfs' => $pdfs,
                    'images' => $images
                ]);
            } else {
                $this->sendRes('ليس لديك صلاحية', false);
            }
        } else {
            return $this->sendRes('الرسالة غير موجودة', false);
        }
    }


}
