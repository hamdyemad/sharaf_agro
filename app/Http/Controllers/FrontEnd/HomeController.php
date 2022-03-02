<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('name')->get();
        return view('frontend.home', compact('branches'));
    }

    public function login() {
        return view('frontend.auth.login');
    }

    public function register() {
        return view('frontend.auth.register');
    }
    public function signup(Request $request)
    {
        $creation = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'user',
            'active' => 1,
            'password' => Hash::make($request->password)
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروفا',
            'name.max' => 'يجب ادخال حروف اقل من 255',
            'email.required' => 'البريد الألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروفا',
            'email.max' => 'يجب ادخال حروف اقل من 255',
            'email.unique' => 'البريد الألكترونى هذا موجود بالفعل',
            'password.required' =>'الرقم السرى مطلوب',
            'password.string' =>'الرقم السرى يجب أن يكون حروفا',
            'password.min' =>'ادخل حروف اكثر من 8',
            'password.confirmed' => 'يجب على الرقم السرى أن يكون مطابق',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما فى التسجيل')->withInput($request->all());
        }
        $user = User::create($creation);
        Auth::login($user);
        if($request->session()->has('carts')) {
            return redirect(route('frontend.cart'))->with('success', 'تم انشاء الحساب بنجاح');
        } else {
            return redirect()->back()->with('success', 'تم انشاء الحساب بنجاح');
        }
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

    public function product(Product $product) {
        return view('frontend.product', compact('product'));
    }


    public function receiveType(Request $request) {
        if($request->has('type')) {
            $request->session()->put('order_type', $request->type);
        }
        if($request->session()->has('carts') && count($request->session()->get('carts')) > 0) {
            return view('frontend.receive');
        } else {
            return redirect(route('frontend.home'))->with('error', 'السلة فارغة');
        }
    }


    public function payment(Request $request) {
        if($request->session()->has('order_type') && $request->session()->has('carts')) {
            if(count($request->session()->get('carts')) > 0) {
                $countries = Country::orderBy('name')->get();
                return view('frontend.payment', compact('countries'));
            } else {
            return redirect(route('frontend.receive'))->with('error', 'يجب أن تحدد طريفة الأستلام أولا');
            }
        } else {
            return redirect(route('frontend.receive'))->with('error', 'يجب أن تحدد طريفة الأستلام أولا');
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
