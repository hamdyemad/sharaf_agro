<?php

namespace App\Http\Controllers\Api;

use App\Events\RealInquire;
use App\Http\Controllers\Controller;
use App\Mail\SendInquire;
use App\Models\Category;
use App\Models\Inquire;
use App\Models\InquireHistory;
use App\Models\InquireView;
use App\Models\Status;
use App\Models\SubCategory;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\Res;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InquiresController extends Controller
{
    use Res;
    public function index(Request $request) {
        if(Auth::user()->type == 'user') {
            $inquires = Inquire::where('customer_id', Auth::id())->latest();
        } else if(Auth::user()->type == 'sub-admin' && Auth::user()->can('inquires.index') == true) {
            $user_categories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $user_sub_categories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $inquires = Inquire::
            whereIn('category_id', $user_categories)
            ->whereIn('sub_category_id', $user_sub_categories)
            ->latest();
        } else if(Auth::user()->type == 'admin') {
            $inquires = Inquire::latest();
        } else {
            return $this->sendRes('ليس لديك صلاحية', false);
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
        $inquires = $inquires->with(['category', 'sub_category', 'customer'])->get();
        return $this->sendRes('', true, $inquires);
    }
    public function store(Request $request)
    {
        $status = Status::where('name', 'معلق')->first();
        $creation = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_id' => Auth::id(),
            'sender_name' => $request->sender_name,
            'sender_phone' => $request->sender_phone,
            'details' => $request->details,
        ];
        if($status) {
            if(Auth::user()->type == 'user') {
                $rules = [
                    'category_id' => 'required|exists:categories,id|max:255',
                    'details' => 'required|string',
                    'sender_name' => 'required|string',
                    'sender_phone' => 'required|string',
                ];
                $messages = [
                    'category_id.required' => 'القسم الرئيسى مطلوب',
                    'category_id.exists' => 'القسم الرئيسى غير موجود',
                    'details.required' => 'الأستفسار مطلوب',
                    'details.string' => ' الأستفسار يجب أن يكون من نوع string',
                    'sender_name.required' => ' الأسم مطلوب',
                    'sender_name.string' => 'الأسم يجب أن يكون من نوع string',
                    'sender_phone.required' => ' رقم الموبيل مطلوب',
                ];
                $subs = SubCategory::where('category_id', $request['category_id'])->get();
                if($subs->count() > 0) {
                    $rules['sub_category_id'] = 'required|exists:sub_categories,id';
                }
                $validator = Validator::make($request->all(), $rules, $messages);
                if($validator->fails()) {
                    return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
                }
                $data = [
                    'name' => Auth::user()->name,
                    'category_name' => Category::find($request->category_id)->name,
                    'details' => $request->details,
                    'subject' => 'أستفسار جديد من ' . Auth::user()->name,
                    'sender_name' => $request->sender_name,
                    'sender_phone' => $request->sender_phone,
                ];

                $main_category = Category::find($request->category_id);
                if($main_category->sub_categories->count() == 0) {
                    $userCategories = UserCategory::where('category_id', $request->category_id)->get();
                    if($userCategories->count() > 0) {
                        foreach ($userCategories as $userCategory) {
                            try {
                                Mail::to($userCategory->user->email)->send(new SendInquire($data));
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
                            try {
                                Mail::to($userSubCategory->user->email)->send(new SendInquire($data));
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
                        Mail::to(User::where('type', 'admin')->first()->email)->send(new SendInquire($data));
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
                $inquire = Inquire::create($creation);
                $passedDataOfRealTime = [
                    'inquire' => $inquire,
                    'customer_name' => $inquire->customer->name,
                    'main_category' => $inquire->category->name,
                    'sub_category' => '',
                    'status' => $status->name
                ];
                if($request->sub_category_id) {
                    $sub_category_name = $inquire->category->sub_categories->find($request->sub_category_id)->name;
                    $passedDataOfRealTime['sub_category'] = $sub_category_name;
                }
                try {
                    event(new RealInquire($passedDataOfRealTime));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return $this->sendRes('تم انشاء الأستفسار بنجاح', true);
            } else {
                return $this->sendRes('المستخدم ليس من نوع شركة  لأنشاء استفسار', false);
            }
        } else {
            return $this->sendRes('الحالة غير موجودة', false);
        }
    }


    public function add_reply(Request $request, $id) {
        $inquire = Inquire::find($id);
        if($inquire) {
            if($inquire->reply !== null) {
                return $this->sendRes('تم اضافة رد من قبل', true);
            } else {
                $validator = Validator::make($request->all(), [
                    'reply' => 'required'
                ], [
                    'reply.required' => 'الرد مطلوب'
                ]);
                if($validator->fails()) {
                    return $this->sendRes('يوجد خطأ ما', false, $validator->errors());
                }
                $inquire->update([
                    'reply' => $request->reply
                ]);
                $data = [
                    'name' => $inquire->customer->name,
                    'category_name' => $inquire->category->name,
                    'subject' => 'أستفسار من ' . $inquire->customer->name,
                    'user' => Auth::user()->name,
                    'details' => $inquire->details,
                    'sender_name' => $inquire->sender_name,
                    'sender_phone' => $inquire->sender_phone,
                    'reply' => $inquire->reply
                ];
                if($inquire->sub_category) {
                    $data['sub_category_name'] = $inquire->sub_category->name;
                }
                if($inquire->sub_category_id) {
                    $users_sub_categories = UserSubCategory::where('sub_category_id', $inquire->sub_category_id)->get();
                    // ارسال رسائل للموظفين المختصين بالقسم الفرعى
                    if($users_sub_categories->count() > 0) {
                        foreach ($users_sub_categories as $users_sub_category) {
                            try {
                                Mail::to($users_sub_category->user->email)->send(new SendInquire($data));
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        }
                    }
                } else {
                    $users_categories = UserCategory::where('category_id', $inquire->category_id)->get();
                    // ارسال رسائل للموظفين المختصين بالقسم الرئيسى لو مفيش فرعى
                    if($users_categories->count() > 0) {
                        foreach ($users_categories as $users_category) {
                            try {
                                Mail::to($users_category->user->email)->send(new SendInquire($data));
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                        }
                    }
                }
                $admin = User::where('type', 'admin')->first();
                // send Mail to admin
                if($admin->email) {
                    try {
                        Mail::to(User::where('type', 'admin')->first()->email)->send(new SendInquire($data));
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
                // ارسال اميل للشركات
                try {
                    Mail::to($inquire->customer->email)->send(new SendInquire($data));
                } catch (\Throwable $th) {
                    throw $th;
                }
                // Make Inquire History
                InquireHistory::create([
                    'inquire_id' => $inquire->id,
                    'user_id' => Auth::id()
                ]);
                return $this->sendRes('تم اضافة الرد بنجاح', true);
            }
        } else {
            return $this->sendRes('الأستفسار غير موجود', false);
        }
    }

    public function show($id)
    {
        $inquire = Inquire::where('id', $id)->with(['category', 'sub_category', 'customer'])->first();
        if($inquire) {
            return $this->sendRes('تم جلب الأستفسار', true, $inquire);
        } else {
            return $this->sendRes('الأستفسار غير موجود', false);
        }
    }
}
