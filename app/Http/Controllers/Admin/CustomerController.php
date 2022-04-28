<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerBalance;
use App\Models\CustomerResponsible;
use App\Traits\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('customers.index');
        $users = User::where('type', '=', 'user')->where('id', '!=', Auth::id());
        if($request->name) {
            $users->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->username) {
            $users->where('username', 'like', '%' . $request->username . '%');
        }
        if($request->email) {
            $users->where('email', 'like', '%' . $request->email . '%');
        }
        if($request->phone) {
            $users->where('phone', 'like', '%' . $request->phone . '%');
        }
        if($request->banned) {
            $users->where('banned', 'like', '%' . $request->banned . '%');
        }
        $users = $users->latest()->paginate(10);
        return view('users.customers.index', compact('users'));
    }

    public function profile(User $user) {
        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('customers.create');
        return view('users.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('customers.create');
        $creation = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'type' => 'user',
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'avatar' => ['image'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'responsible.*.name' => ['required', 'string', 'max:255'],
            'responsible.*.phone' => ['required', 'string', 'max:255'],
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروف او ارقام',
            'name.max' => 'يجب أدخال أقل من 255 حرف',

            'email.required' => 'البريدالألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروف او ارقام',
            'email.max' => 'يجب أدخال أقل من 255 حرف',
            'email.unique' => 'البريد هذا موجود بالفعل',

            'username.required' => 'أسم المستخدم مطلوب',
            'username.string' => 'أسم المستخدم يجب أن يكون حروف او ارقام',
            'username.max' => 'يجب أدخال أقل من 255 حرف',
            'username.unique' => 'أسم المستخدم هذا موجود بالفعل',

            'password.required' => 'الرقم السرى مطلوب',
            'password.string' => 'الرقم السرى يجب أن يكون حروف او ارقام',
            'password.min' => 'يجب على الأقل ادخال أكثر من 8 حروف',
            'password.confirmed' => 'الرقم السرى غير متطابق',

            'avatar.image' => 'يجب أن يكون الحقل فى هيئة صورة',

            'responsible.*.name.required' => 'أسم المسئول مطلوب',
            'responsible.*.name.string' => ' أسم المسئول يجب أن يكون حروف او ارقام',
            'responsible.*.name.max' => 'يجب أدخال أقل من 255 حرف',

            'responsible.*.phone.required' => 'رقم المسئول مطلوب',
            'responsible.*.phone.string' => ' رقم المسئول يجب أن يكون أرقام',
            'responsible.*.phone.max' => 'يجب أدخال أقل من 255 حرف',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $creation['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
        }

        $user = User::create($creation);
        if($request['responsible']) {
            foreach ($request['responsible'] as $responsible) {
                CustomerResponsible::create([
                    'user_id' => $user->id,
                    'name' => $responsible['name'],
                    'phone' => $responsible['phone'],
                ]);
            }
        }

        return redirect()->to(route('customers.index'))->with('success', 'تم انشاء حساب الشركة بنجاح');
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
    public function edit(Request $request,User $user)
    {
        $this->authorize('customers.edit');
        return view('users.customers.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $this->authorize('customers.edit');
        $creation = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users','username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($user->id)],
            'avatar' => ['image'],
            'responsible.*.name' => ['required', 'string', 'max:255'],
            'responsible.*.phone' => ['required', 'string', 'max:255'],
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروف او ارقام',
            'name.max' => 'يجب أدخال أقل من 255 حرف',
            'email.required' => 'البريدالألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروف او ارقام',
            'email.max' => 'يجب أدخال أقل من 255 حرف',
            'email.unique' => 'البريد هذا موجود بالفعل',
            'username.required' => 'أسم الشركة مطلوب',
            'username.string' => 'أسم الشركة يجب أن يكون حروف او ارقام',
            'username.max' => 'يجب أدخال أقل من 255 حرف',
            'username.unique' => 'أسم الشركة هذا موجود بالفعل',
            'avatar.image' => 'يجب أن يكون الحقل فى هيئة صورة',

            'responsible.*.name.required' => 'أسم المسئول مطلوب',
            'responsible.*.name.string' => ' أسم المسئول يجب أن يكون حروف او ارقام',
            'responsible.*.name.max' => 'يجب أدخال أقل من 255 حرف',

            'responsible.*.phone.required' => 'رقم المسئول مطلوب',
            'responsible.*.phone.string' => ' رقم المسئول يجب أن يكون أرقام',
            'responsible.*.phone.max' => 'يجب أدخال أقل من 255 حرف',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $creation['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
            if(file_exists($user->avatar)) {
                $img = last(explode('/', $user->avatar));
                if(in_array($img, scandir(dirname($user->avatar)))) {
                    unlink($user->avatar);
                }
            }
        }
        $user->update($creation);
        // Remove All user Responsible
        CustomerResponsible::where('user_id', $user->id)->delete();
        // Add New User Responsible
        if($request['responsible']) {
            foreach ($request['responsible'] as $responsible) {
                CustomerResponsible::create([
                    'user_id' => $user->id,
                    'name' => $responsible['name'],
                    'phone' => $responsible['phone'],
                ]);
            }
        }

        return redirect()->back()->with('info', 'تم تعديل الشركة بنجاح');
    }

    public function banned(Request $request, User $user) {
        if($request->active == 'on') {
            $user->update(['banned' => 1]);
            return redirect()->back()->with('success', 'تم الحظر');
        } else {
            $user->update(['banned' => 0]);
            return redirect()->back()->with('success', 'تم فك الحظر');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('customers.destroy');
        if(file_exists($user->avatar)) {
            $img = last(explode('/', $user->avatar));
            if(in_array($img, scandir(dirname($user->avatar)))) {
                unlink($user->avatar);
            }
        }
        User::destroy($user->id);
        return redirect()->back()->with('success', 'تم ازالة الشركة بنجاح');

    }
}
