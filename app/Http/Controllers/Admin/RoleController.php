<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permession;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('roles.index');
        Carbon::setLocale('ar');
        $roles = Role::latest();
        $roles = $roles->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('roles.create');
        $permessions = Permession::all()->groupBy('group_by');
        return view('roles.create', compact('permessions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('roles.create');
        $rules = [
            'name' => 'required|string|unique:roles,name',
            'permessions' => 'required'
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.unique' => 'يجب أن تختار أسم غير موجود بالفعل',
            'permessions.required' => 'الصلاحيات مطلوبة',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما')->withInput($request->all());
        }
        $role = Role::create([
            'name' => $request->name
        ]);
        foreach ($request->permessions as $permession) {
            $role->permessions()->attach($permession);
        }
        return redirect()->back()->with('success', 'تم انشاء الصلاحية بنجاح');

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
    public function edit(Role $role)
    {
        $this->authorize('roles.edit');
        $permessions = Permession::all()->groupBy('group_by');
        return view('roles.edit', compact('role', 'permessions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('roles.edit');
        $rules = [
            'name' => ['required','string', Rule::unique('roles', 'name')->ignore($role->id)],
            'permessions' => 'required'
        ];
        $messages = [
            'name.required' => 'الأسم مطلوب',
            'name.unique' => 'يجب أن تختار أسم غير موجود بالفعل',
            'permessions.required' => 'الصلاحيات مطلوبة',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما')->withInput($request->all());
        }
        $role->update([
            'name' => $request->name
        ]);
        // remove all previous permessions
        foreach ($role->permessions as $permession) {
            $role->permessions()->detach($permession);
        }
        // add new permessions
        foreach ($request->permessions as $permession) {
            $role->permessions()->attach($permession);
        }
        return redirect()->back()->with('info', 'تم تعديل الصلاحية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize('roles.destroy');
        Role::destroy($role->id);
        return redirect()->back()->with('success', 'تمت ازالة الصلاحية بنجاح');

    }
}
