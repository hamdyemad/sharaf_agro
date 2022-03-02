<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Status;
use App\Traits\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    use File;
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
    public function show(User $user)
    {
        return view('frontend.user.profile', compact('user'));
    }
    public function update_profile(Request $request, User $user)
    {
        $updateArray = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروفا',
            'name.max' => 'يجب ادخال حروف اقل من 255',
            'email.required' => 'البريد الألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروفا',
            'email.max' => 'يجب ادخال حروف اقل من 255',
            'email.unique' => 'البريد الألكترونى هذا موجود بالفعل'
        ];
        if($request->password !== null) {
            $updateArray['password'] = Hash::make($request->password);
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما فى التعديل')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $updateArray['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
            if(file_exists($user->avatar)) {
                $img = last(explode('/', $user->avatar));
                if(in_array($img, scandir(dirname($user->avatar)))) {
                    unlink($user->avatar);
                }
            }
        }
        $user->update($updateArray);
        return redirect()->back()->with('info', 'تم تعديل الحساب بنجاح');
    }

    public function logout() {
        Auth::logout();
        return redirect(route('frontend.home'))->with('success', 'تم تسجيل الخروج');
    }


    public function orders(Request $request) {
        Carbon::setLocale('ar');
        $orders = Order::where('user_id', Auth::id())->latest();
        $statuses = Status::all();
        $branches = Branch::all();
        if($request->customer_name) {
            $orders = $orders->where('customer_name', 'like', '%' . $request->customer_name .'%');
        }
        if($request->customer_phone) {
            $orders = $orders->where('customer_phone', 'like', '%' . $request->customer_phone .'%');
        }
        if($request->type) {
            $orders = $orders->where('type', 'like', '%' . $request->type .'%');
        }
        if($request->branch_id) {
            $orders = $orders->where('branch_id', 'like', '%' . $request->type .'%');
        }
        if($request->status_id) {
            $orders = $orders->where('status_id', 'like', '%' . $request->status_id .'%');
        }
        $orders = $orders->paginate(10);
        foreach($orders as $order) {
            $order->update([
                'client_viewed' => true,
                'client_status_viewed' => true,
            ]);
        }
        return view('frontend.user.orders', compact('orders', 'statuses', 'branches'));
    }

    public function orders_show(Request $request, Order $order) {
        $order->update([
            'client_viewed' => true,
            'client_status_viewed' => true,
        ]);
        return view('frontend.user.order_show', compact('order'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
