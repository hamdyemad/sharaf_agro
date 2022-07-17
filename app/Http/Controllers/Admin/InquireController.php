<?php

namespace App\Http\Controllers\Admin;

use App\Events\RealInquire;
use App\Exports\InquireExport;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Mail\SendInquire;
use App\Mail\SendNew;
use App\Models\Inquire;
use App\Models\InquireHistory;
use App\Models\InquireView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class InquireController extends Controller
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
        $statuses = Status::whereIn('name', ['تم التواصل', 'معلق'])->orderBy('name')->get();
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
            return abort(401);
        }
        if(Auth::user()->type == 'admin' || Auth::user()->type == 'user') {
            $categories = Category::all();
        } else {
            $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $categories = Category::whereIn('id',$employeeCategories)->get();
        }
        if($request->sender_name) {
            $inquires->where('sender_name', 'like', '%'. $request->sender_name . '%');
        }
        if($request->sender_phone) {
            $inquires->where('sender_phone', 'like', '%'. $request->sender_phone . '%');
        }
        if($request->details) {
            $inquires->where('details', 'like', '%'. $request->details . '%');
        }
        if($request->customer_id) {
            $inquires->where('customer_id', $request->customer_id);
        }
        if($request->category_id) {
            $inquires->where('category_id', $request->category_id);
        }
        if($request->sub_category_id) {
            $inquires->where('sub_category_id', $request->sub_category_id);
        }
        $inquires = $inquires->paginate(10);
        return view('inquires.index', compact('inquires', 'categories', 'statuses'));
    }
    public function export(Request $request)
    {
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
            return abort(401);
        }
        if($request->details) {
            $inquires->where('details', 'like', '%'. $request->details . '%');
        }
        if($request->sender_name) {
            $inquires->where('sender_name', 'like', '%'. $request->sender_name . '%');
        }
        if($request->sender_phone) {
            $inquires->where('sender_phone', 'like', '%'. $request->sender_phone . '%');
        }
        if($request->customer_id) {
            $inquires->where('customer_id', $request->customer_id);
        }
        if($request->category_id) {
            $inquires->where('category_id', $request->category_id);
        }
        if($request->sub_category_id) {
            $inquires->where('sub_category_id', $request->sub_category_id);
        }
        $inquires = $inquires->get();
        return Excel::download(new InquireExport($inquires), 'inquires.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->type == 'user') {
            $categories = Category::all();
            return view('inquires.create', compact('categories'));
        } else {
            return redirect()->to(route('inquires.index'))->with('error', 'هذه الصفحة خاصة بالشركات');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $creation = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_id' => Auth::id(),
            'sender_name' => $request->sender_name,
            'sender_phone' => $request->sender_phone,
            'details' => $request->details,
        ];
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
            'sender_name.required' => 'أسم الراسل مطلوب',
            'sender_phone.required' => 'رقم موبيل الراسل مطلوب',
        ];
        $subs = SubCategory::where('category_id', $request['category_id'])->get();
        if($subs->count() > 0) {
            $rules['sub_category_id'] = 'required|exists:sub_categories,id';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
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
        return redirect()->to(route('inquires.index'))->with('success', 'تم انشاء الأستفسار بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inquire $inquire)
    {
        if(Auth::user()->type == 'user' || Auth::user()->can('inquires.show')) {
            $inquire_view = InquireView::
            where('inquire_id', $inquire->id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$inquire_view) {
                InquireView::create([
                    'inquire_id' => $inquire->id,
                    'user_id' => Auth::id(),
                    'viewed' => 1
                ]);
            } else {
                $inquire_view->update([
                    'viewed' => 1
                ]);
            }
            return view('inquires.show', compact('inquire'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Inquire $inquire)
    {
        if(Auth::user()->type == 'user' || Auth::user()->can('inquires.edit')) {
            $categories = Category::all();
            $userCategories =  UserCategory::where('user_id', auth()->id())->get();
            $customers = User::where('type', 'user')->get();
            return view('inquires.edit', compact('inquire','userCategories', 'categories', 'customers'));
        } else {
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inquire $inquire)
    {
        if($request->add_reply) {
            $validator = Validator::make($request->all(), [
                'reply' => 'required'
            ], [
                'reply.required' => 'الرد مطلوب'
            ]);
            if($validator->fails()) {
                return redirect()->to(route('inquires.index', ['inquire_id' => $inquire->id]))->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
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
        } else {
            $creation = [
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sender_name' => $request->sender_name,
                'sender_phone' => $request->sender_phone,
            ];
            $rules = [
                'category_id' => 'required|exists:categories,id|max:255',
                'sender_name' => 'required|string',
                'sender_phone' => 'required|string',
            ];
            $messages = [
                'category_id.required' => 'القسم الرئيسى مطلوب',
                'category_id.exists' => 'القسم الرئيسى غير موجود',
                'sender_name.required' => 'أسم الراسل مطلوب',
                'sender_phone.required' => 'رقم موبيل الراسل مطلوب',
            ];
            $subs = SubCategory::where('category_id', $request['category_id'])->get();
            if($subs->count() > 0) {
                $rules['sub_category_id'] = 'required|exists:sub_categories,id';
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
            }
            $inquire->update($creation);
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
        }
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
        return redirect()->to(route('inquires.index', ['page' => $request->page]))->with('success', 'تم تعديل الأستفسار بنجاح');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inquire $inquire)
    {
        Inquire::destroy($inquire->id);
        return redirect()->back()->with('success', 'تم ازالة الأستفسار بنجاح');
    }
}
