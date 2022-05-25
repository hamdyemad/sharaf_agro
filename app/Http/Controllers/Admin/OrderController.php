<?php

namespace App\Http\Controllers\Admin;

use App\Events\newOrder;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Mail\SendOrder;
use App\Models\Category;
use App\Models\FirebaseToken;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderView;
use App\Models\Status;
use App\Models\SubCategory;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use App\Traits\File;
use App\Traits\FirebaseNotify;
use App\Traits\Res;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Customer;

use function GuzzleHttp\Promise\all;

class OrderController extends Controller
{
    use File, FirebaseNotify, Res;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    $employeeSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                    $categories = Category::whereIn('id',$employeeCategories)->get();
                }
                $statuses = Status::whereIn('name',['مكتمل', 'تم التقديم', 'تحت الأنشاء'])->orderBy('name')->get();
                if(Auth::user()->type == 'admin') {
                    $orders = Order::latest();
                } else if(Auth::user()->type == 'sub-admin') {
                    $orders = Order::
                    whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)
                    ->latest();
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
                return view('orders.index', compact('orders', 'customers', 'employees', 'categories', 'statuses'));
        } else {
            return abort(401);
        }
    }

    public function export(Request $request) {
        if(Auth::user()->type == 'admin') {
            $orders = Order::latest();
        } else if(Auth::user()->type == 'sub-admin') {
            $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
            $employeeSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
            $orders = Order::
                    whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)
                    ->latest();
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
        $orders = $orders->get();
        return Excel::download(new OrderExport($orders), 'orders.xlsx');
    }

    public function alerts(Request $request) {
        if(
            Auth::user()->type == 'sub-admin' && $this->authorize('orders.alerts.index')
            || Auth::user()->type == 'user' || Auth::user()->type == 'admin') {
                $orders = Order::orderBy('updated_at', 'DESC')->orderBy('expected_date', 'DESC');
                if(Auth::user()->type == 'admin') {
                    $orders = $orders->latest();
                } else if(Auth::user()->type == 'sub-admin') {
                    $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
                    $employeeSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                    $orders = Order::
                    whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)
                    ->latest();
                } else if(Auth::user()->type == 'user') {
                    $orders =  $orders->where('customer_id', Auth::id())->latest();
                }
                $orders = $orders->paginate(10);
                return view('orders.alerts', compact('orders'));
        } else {
            return abort(401);
        }
    }

    public function alerts_renovations(Request $request) {
        if(
            Auth::user()->type == 'sub-admin' && $this->authorize('orders.alerts.renovations')
            || Auth::user()->type == 'user' || Auth::user()->type == 'admin') {
                $orders = Order::where('expiry_date', '!=', null)
                ->orderBy('updated_at', 'DESC')->orderBy('expiry_date', 'DESC')
                ->whereColumn('expiry_date', '<', 'expiry_date_notify');
                if(Auth::user()->type == 'admin') {
                    $orders = $orders->latest();
                } else if(Auth::user()->type == 'sub-admin') {
                    $employeeCategories = UserCategory::where('user_id', Auth::id())->pluck('category_id');
                    $employeeSubCategories = UserSubCategory::where('user_id', Auth::id())->pluck('sub_category_id');
                    $orders = Order::
                    whereIn('category_id', $employeeCategories)
                    ->whereIn('sub_category_id', $employeeSubCategories)
                    ->latest();
                } else if(Auth::user()->type == 'user') {
                    $orders =  $orders->where('customer_id', Auth::id())->latest();
                }
                $orders = $orders->paginate(10);
                return view('orders.alerts_renovations', compact('orders'));
        } else {
            return abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('orders.create');
        $categories = Category::all();
        $userCategories =  UserCategory::where('user_id', auth()->id())->get();
        $customers = User::where('type', 'user')->get();
        $statuses = Status::whereIn('name',['تحت الأنشاء', 'تم التقديم', 'مكتمل'])->orderBy('name')->get();
        return view('orders.create', compact('userCategories', 'categories', 'customers', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('orders.create');
        $status = Status::find($request['status_id']);
        $creation = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_id' => $request->customer_id,
            'employee_id' => Auth::id(),
            'status_id' => $request->status_id,
            'name' => $request->name,
            'details' => $request->details,
            'submission_date' => $request->submission_date,
            'expected_date' => $request->expected_date,
            'expiry_date' => $request->expiry_date,
            'expiry_date_notify' => $request->expiry_date_notify
        ];
        if($status) {
            $rules = [
                'category_id' => 'required|exists:categories,id|max:255',
                'customer_id' => 'required|exists:users,id|max:255',
                'name' => 'required|string|max:255',
                'details' => 'required|string',
                'status_id' => 'required|exists:statuses,id',
            ];
            $messages = [
                'category_id.required' => 'القسم الرئيسى مطلوب',
                'category_id.exists' => 'القسم الرئيسى غير موجود',
                'customer_id.required' => 'أختر الشركة',
                'customer_id.exists' => 'الشركة غير موجودة',
                'name.required' => 'أسم المركب مطلوب',
                'name.string' => 'أسم المركب يجب أن يكون من نوع string',
                'name.max' => 'أسم المركب يجب أن يكون أقل من 255 حرف',
                'details.required' => 'تفاصيل المركب مطلوبة',
                'details.string' => 'تفاصيل المركب يجب أن يكون من نوع string',
                'status_id.required' => 'الحالة مطلوبة',
                'status_id.exists' => 'الحالة غير موجودة',
            ];
            $subs = SubCategory::where('category_id', $request['category_id'])->get();
            if($subs->count() > 0) {
                $rules['sub_category_id'] = 'required|exists:sub_categories,id';
            }
            if($status->name == 'تم التقديم') {
                $rules['submission_date'] = 'required|date';
                $rules['expected_date'] = 'required|date';
                $messages['submission_date.required'] = 'تاريخ التقديم مطلوب';
                $messages['submission_date.date'] = 'الصيغة يجب أن تكون من نوع date';
                $messages['expected_date.required'] = 'الناريخ المتوقع مطلوب';
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
            }
            if($request['files']) {
                foreach ($request->file('files') as $file) {
                    $files[] = $this->uploadFiles($file, $this->ordersPath);
                }
                $creation['files'] = json_encode($files);
            }
            if($request->has('show_details')) {
                $creation['show_details'] = 1;
            }
            $order = Order::create($creation);
            $main_category = Category::find($request->category_id);
            $data = [
                'name' => $request->name,
                'customer_name' => $order->customer->name,
                'status_name' => $status->name,
                'category_name' => $main_category->name,
                'details' => $request->details,
                'subject' => $request->name . ' (طلب جديد)'
            ];
            $passedDataOfRealTime = [
                'order' => $order,
                'main_category' => $main_category->name,
                'sub_category' => '',
                'status' => $status->name
            ];
            if($request->sub_category_id) {
                $sub_category_name = $main_category->sub_categories->find($request->sub_category_id)->name;
                $data['sub_category_name'] = $sub_category_name;
                $passedDataOfRealTime['sub_category'] = $sub_category_name;
            }
            try {
                // Send Notification with firebase to mobiles
                $tokens = FirebaseToken::where('user_id', $order->customer_id)->get();
                if($tokens->count() > 0) {
                    foreach ($tokens as $token) {
                        $this->send_notify($token, $order->name, 'تم انشاء مركب جديد أتطلع عليه الأن');
                    }
                }
                event(new newOrder($passedDataOfRealTime));
            } catch (\Throwable $th) {
                //throw $th;
            }
            try {
                Mail::to($order->customer->email)->send(new SendOrder($data));
            } catch (\Throwable $th) {
                throw $th;
            }
            return redirect()->to(route('orders.index'))->with('success', 'تم انشاء الطلب بنجاح');
        } else {
            return redirect()->back()->with('error', 'الحالة غير موجودة');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if(Auth::user()->type == 'user' || $this->authorize('orders.show')) {
            $pdfs = [];
            $images = [];
            $order_view = OrderView::
            where('order_id', $order->id)
            ->where('user_id', Auth::id())
            ->first();
            if(!$order_view) {
                OrderView::create([
                    'order_id' => $order->id,
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
            return view('orders.show', compact('order', 'images', 'pdfs'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $this->authorize('orders.edit');
        $categories = Category::all();
        $userCategories =  UserCategory::where('user_id', auth()->id())->get();
        $customers = User::where('type', 'user')->get();
        $statuses = Status::whereIn('name', ['تحت الأنشاء', 'تم التقديم', 'مكتمل'])->orderBy('name')->get();
        return view('orders.edit', compact('order','userCategories', 'categories', 'customers', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('orders.edit');
        $status = Status::find($request['status_id']);
        $creation = [
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'customer_id' => $request->customer_id,
            'status_id' => $request->status_id,
            'name' => $request->name,
            'details' => $request->details,
            'submission_date' => $request->submission_date,
            'expected_date' => $request->expected_date,
            'expiry_date' => $request->expiry_date,
            'expiry_date_notify' => $request->expiry_date_notify
        ];
        if($status) {
            $rules = [
                'category_id' => 'required|exists:categories,id|max:255',
                'customer_id' => 'required|exists:users,id|max:255',
                'name' => 'required|string|max:255',
                'details' => 'required|string',
                'status_id' => 'required|exists:statuses,id',
            ];
            $messages = [
                'category_id.required' => 'القسم الرئيسى مطلوب',
                'category_id.exists' => 'القسم الرئيسى غير موجود',
                'customer_id.required' => 'أختر الشركة',
                'customer_id.exists' => 'الشركة غير موجودة',
                'name.required' => 'أسم المركب مطلوب',
                'name.string' => 'أسم المركب يجب أن يكون من نوع string',
                'name.max' => 'أسم المركب يجب أن يكون أقل من 255 حرف',
                'details.required' => 'تفاصيل المركب مطلوبة',
                'details.string' => 'تفاصيل المركب يجب أن يكون من نوع string',
                'status_id.required' => 'الحالة مطلوبة',
                'status_id.exists' => 'الحالة غير موجودة',
            ];
            $subs = SubCategory::where('category_id', $request['category_id'])->get();
            if($subs->count() > 0) {
                $rules['sub_category_id'] = 'required|exists:sub_categories,id';
            }
            if($status->name == 'تم التقديم') {
                $rules['submission_date'] = 'required|date';
                $rules['expected_date'] = 'required|date';
                $messages['submission_date.required'] = 'تاريخ التقديم مطلوب';
                $messages['submission_date.date'] = 'الصيغة يجب أن تكون من نوع date';
                $messages['expected_date.required'] = 'الناريخ المتوقع مطلوب';
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
            }
            if($request['files']) {
                if($order->files) {
                    $files = json_decode($order->files);
                } else {
                    $files = [];
                }
                foreach ($request->file('files') as $file) {
                    array_push($files, $this->uploadFiles($file, $this->ordersPath));
                }
                $creation['files'] = json_encode($files);
            }
            if($request->has('show_details')) {
                $creation['show_details'] = 1;
            }
            $order->update($creation);
            $passedDataOfRealTime = [
                'order' => $order,
                'customer_name' => $order->customer->name,
                'main_category' => $order->category->name,
                'sub_category' => '',
                'status' => $status->name
            ];
            if($request->sub_category_id) {
                $sub_category_name = $order->category->sub_categories->find($request->sub_category_id)->name;
                $passedDataOfRealTime['sub_category'] = $sub_category_name;
            }
            try {
                // Send Notification with firebase to mobiles
                $tokens = FirebaseToken::where('user_id', $order->customer_id)->get();
                if($tokens->count() > 0) {
                    foreach ($tokens as $token) {
                        $this->send_notify($token, $order->name, 'تعديل جديد على المركب أتطلع عليه الأن');
                    }
                }

                event(new newOrder($passedDataOfRealTime));
            } catch (\Throwable $th) {
                //throw $th;
            }
            $orders_view = OrderView::
            where('order_id', $order->id)
            ->get();
            if($orders_view->count() > 0) {
                foreach ($orders_view as $order_view) {
                    $order_view->update([
                        'viewed' => 0
                    ]);
                }
            }
            // Make Order History
            OrderHistory::create([
                'order_id' => $order->id,
                'status_id' => $order->status_id,
                'user_id' => Auth::id()
            ]);
            $main_category = Category::find($request->category_id);
            $data = [
                'name' => $request->name,
                'status_name' => $status->name,
                'category_name' => $main_category->name,
                'details' => $request->details,
                'subject' => $request->name . ' (تعديل جديد على الطلب)',
                'user' => Auth::user()->name
            ];
            if($request->sub_category_id) {
                $data['sub_category_name'] = $main_category->sub_categories->find($request->sub_category_id)->name;
            }
            try {
                Mail::to($order->customer->email)->send(new SendOrder($data));
            } catch (\Throwable $th) {
                throw $th;
            }
            return redirect()->to(route('orders.index'))->with('success', 'تم تعديل الطلب بنجاح');
        } else {
            return redirect()->back()->with('error', 'الحالة غير موجودة');
        }
    }

    public function remove_files(Request $request, $id) {
        $order = Order::find($id);
        if(file_exists(json_decode($order->files)[$request->index])) {
            $files = json_decode($order->files, true);
            unlink($files[$request->index]);
            array_splice($files, $request->index, 1);
            $order->update([
                'files' => json_encode($files)
            ]);
        }
        return $this->sendRes('تم ازالة الملف بنجاح', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('orders.destroy');
        if($order->files) {
            foreach (json_decode($order->files) as $file) {
                if(file_exists($file)) {
                    unlink($file);
                }
            }
        }
        Order::destroy($order->id);
        return redirect()->back()->with('success', 'تم ازالة الطلب بنجاح');

    }
}
