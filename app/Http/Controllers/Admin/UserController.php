<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Role;
use App\Models\SubCategory;
use App\Models\UserCategory;
use App\Models\UserInfo;
use App\Models\UserSubCategory;
use App\Traits\File;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use File;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('users.index');
        $users = User::where([
            ['type','!=', 'admin'],
            ['type','!=', 'user'],
            ['id','!=', Auth::id()],
        ]);
        $roles = Role::latest()->get();
        if($request->name) {
            $users->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->username) {
            $users->where('username', 'like', '%' . $request->username . '%');
        }
        if($request->role_id) {
            $users = $users->whereHas('roles',function ($query) use($request) {
                return $query->where('roles.id', $request->role_id);
            });
        }
        if($request->email) {
            $users->where('email', 'like', '%' . $request->email . '%');
        }
        if($request->banned) {
            $users->where('banned', 'like', '%' . $request->banned . '%');
        }
        $users = $users->latest()->paginate(10);
        return view('users.index', compact('users', 'roles'));
    }

    public function profile(User $user) {
        return view('users.profile', compact('user'));
    }

    public function update_profile(Request $request,User $user) {
        $updateArray = [
            'name' => $request->name,
            'email' => $request->email
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],
            'old_password' => 'required|min:8'
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون من نوع string',
            'name.max' => 'يجب أن يكون الأسم أقل من 255 حرف',
            'email.required' => 'البريد الالكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون من نوع string',
            'email.max' => 'يجب أن يكون البريد أقل من 255 حرف',
            'email.unique' => 'البريد هذا مستخدم من قبل',
            'old_password.required' => 'الرقم السرى مطلوب',
            'old_password.min' => 'الرقم السرى يجب ان يكون على الأقل 8 حروف'
        ];
        $hashed = false;
        $hashed = Hash::check($request->old_password, $user->password);
        if($hashed) {
            if($request->password !== null) {
                $rules['password'] = 'required|min:8';
                $messages['password.required'] = 'الرقم السرى الجديد مطلوب';
                $messages['password.min'] = 'الرقم السرى الجديد يجب أن يكون اكثر من 8 حروف';
            }
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
            }
            if($request->password) {
                $updateArray['password'] = Hash::make($request->password);
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
            return redirect()->back()->with('success', 'تم التعديل بنجاح');
        } else {
            return redirect()->back()->with('old_password.invalid', 'الرقم السرى القديم خطأ');

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('users.create');
        $roles = Role::latest()->get();
        $categories = Category::all();
        if($categories->count() > 0) {
            return view('users.create', compact('roles', 'categories'));
        } else {
            return redirect()->to(route('categories.index'))->with('error', 'يجب أضافة أقسام أولا');
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
        $this->authorize('users.create');
        $creation = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'type' => 'sub-admin',
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ];
        $rules = [
            'roles' => 'required|exists:roles,id',
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'avatar' => ['image'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'categories' => ['required']
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
            'roles.required' => 'الصلاحيات مطلوبة',
            'roles.exists' => 'الصلاحيات غير موجودة',
            'avatar.image' => 'يجب أن يكون الحقل فى هيئة صورة',
            'categories.required' => 'الأقسام مطلوبة',
        ];
        if($request['categories']) {
            $sub_categories = SubCategory::whereIn('category_id', $request['categories'])->get();
            if($sub_categories->count() > 0) {
                $rules['sub_categories'] = 'required';
                $messages['sub_categories.required'] = 'الأقسام الفرعية مطلوبة';
            }
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
        }
        if($request->has('avatar')) {
            $creation['avatar'] = $this->uploadFile($request, $this->usersPath, 'avatar');
        }
        $user = User::create($creation);
        if($request->has('roles')) {
            foreach ($request->roles as $role) {
                $user->roles()->attach($role);
            }
        }
        if($request['categories']) {
            foreach ($request['categories'] as $category) {
                $subCategories = SubCategory::where('category_id', $category)->get();
                UserCategory::create([
                    'user_id' => $user->id,
                    'category_id' => $category
                ]);
            }
            if($request['sub_categories']) {
                foreach ($request['sub_categories'] as $sub_category) {
                    $subCategory = SubCategory::where('id', $sub_category)->first();
                    if($subCategory) {
                        UserSubCategory::create([
                            'user_id' => $user->id,
                            'sub_category_id' => $subCategory->id
                        ]);
                    }
                }
            }
        }
        return redirect()->to(route('users.index'))->with('success', 'تم انشاء حساب الموظف بنجاح');
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
        $this->authorize('users.edit');
        $roles = Role::latest()->get();
        $categories = Category::all();
        if($categories->count() > 0) {
            return view('users.edit', compact('user', 'roles', 'categories'));
        } else {
            return redirect()->to(route('categories.index'))->with('error', 'يجب أضافة أقسام أولا');
        }
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

        $this->authorize('users.edit');
        $creation = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        $rules = [
            'roles' => 'required|exists:roles,id',
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users','username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($user->id)],
            'avatar' => ['image'],
            'categories' => ['required']
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.string' => 'الأسم يجب أن يكون حروف او ارقام',
            'name.max' => 'يجب أدخال أقل من 255 حرف',
            'email.required' => 'البريدالألكترونى مطلوب',
            'email.string' => 'البريد الألكترونى يجب أن يكون حروف او ارقام',
            'email.max' => 'يجب أدخال أقل من 255 حرف',
            'email.unique' => 'البريد هذا موجود بالفعل',
            'username.required' => 'أسم الموظف مطلوب',
            'username.string' => 'أسم الموظف يجب أن يكون حروف او ارقام',
            'username.max' => 'يجب أدخال أقل من 255 حرف',
            'username.unique' => 'أسم الموظف هذا موجود بالفعل',
            'roles.required' => 'الصلاحيات مطلوبة',
            'roles.exists' => 'الصلاحيات غير موجودة',
            'avatar.image' => 'يجب أن يكون الحقل فى هيئة صورة',
            'categories.required' => 'الأقسام مطلوبة',
        ];
        if($request['categories']) {
            $sub_categories = SubCategory::whereIn('category_id', $request['categories'])->get();
            if($sub_categories->count() > 0) {
                $rules['sub_categories'] = 'required';
                $messages['sub_categories.required'] = 'الأقسام الفرعية مطلوبة';
            }
        }
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
        if($request->has('roles')) {
            // Remove All Roles
            foreach ($user->roles as $role) {
                $user->roles()->detach($role);
            }
            // Add New Roles
            foreach ($request->roles as $role) {
                $user->roles()->attach($role);
            }
        }
        // Remove All Categorise For This User
        UserSubCategory::where('user_id', $user->id)->delete();
        UserCategory::where('user_id', $user->id)->delete();
        if($request['categories']) {
            foreach ($request['categories'] as $category) {
                UserCategory::create([
                    'user_id' => $user->id,
                    'category_id' => $category
                ]);
            }
            if($request['sub_categories']) {
                foreach ($request['sub_categories'] as $sub_category) {
                    $subCategory = SubCategory::where('id', $sub_category)->first();
                    if($subCategory) {
                        UserSubCategory::create([
                            'user_id' => $user->id,
                            'sub_category_id' => $subCategory->id
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('info', 'تم تعديل الموظف بنجاح');
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
        $this->authorize('users.destroy');
        if(file_exists($user->avatar)) {
            $img = last(explode('/', $user->avatar));
            if(in_array($img, scandir(dirname($user->avatar)))) {
                unlink($user->avatar);
            }
        }
        User::destroy($user->id);
        return redirect()->back()->with('success', 'تم ازالة الموظف بنجاح');

    }
}
