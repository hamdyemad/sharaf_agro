<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('business.index');
        Carbon::setLocale('ar');
        $branches = Branch::orderBy('name')->get();
        if(Auth::user()->type == 'admin') {
            $businesses = Business::latest();
        } else {
            $businesses = Business::where('branch_id', Auth::user()->branch_id)->latest();
        }
        if($request->name) {
            $businesses->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->branch_id) {
            $businesses->where('branch_id', 'like', '%' . $request->branch_id . '%');
        }
        if($request->type) {
            $businesses->where('type', 'like', '%' . $request->type . '%');
        }
        $businesses = $businesses->paginate(10);
        return view('business.index', compact('businesses', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('business.create');
        $branches = Branch::orderBy('name')->get();
        if(count($branches) > 0) {
            return view('business.create', compact('branches'));
        } else {
            return redirect()->back()->with('error', 'يجب انشاء فروع اولا');
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
        $this->authorize('business.create');
        $rules = [
            'name' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'type' => ['required', Rule::in(['expense', 'income'])]
        ];
        $messages = [
            'name.required' => 'أسم المعاملة مطلوب',
            'type.required' => 'نوع المعاملة مطلوب',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع يجب ان يكون موجود',
            'type.in' => 'يجب أن تكون المعاملة مصروف أو ايراد',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما')->withInput($request->all());
        }
        Business::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
            'type' => $request->type
        ]);
        return redirect()->back()->with('success', 'تم أنشاء المعاملة بنجاح');
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
    public function edit(Business $business)
    {
        $this->authorize('business.edit');
        $branches = Branch::orderBy('name')->get();
        return view('business.edit', compact('business', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        $this->authorize('business.edit');
        $rules = [
            'name' => ['required'],
            'branch_id' => 'required|exists:branches,id',
            'type' => ['required', Rule::in(['expense', 'income'])]
        ];
        $messages = [
            'name.required' => 'أسم المعاملة مطلوب',
            'type.required' => 'نوع المعاملة مطلوب',
            'type.in' => 'يجب أن تكون المعاملة مصروف أو ايراد',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع يجب ان يكون موجود'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد مشكلة ما')->withInput($request->all());
        }
        $business->update([
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'type' => $request->type
        ]);
        return redirect()->back()->with('success', 'تم تعديل المعاملة بنجاح');
    }

    public function all() {
        $this->authorize('business.all');
        Carbon::setLocale('ar');
        if(Auth::user()->type == 'admin') {
            $branches = Branch::orderBy('name')->get();
        } else {
            $branches = Branch::where('id', Auth::user()->branch_id)->orderBy('name')->get();
        }
        return view('business.all', compact('branches'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        $this->authorize('business.destroy');
        Business::destroy($business->id);
        return redirect()->back()->with('success', 'تمت ازالة المعاملة بنجاح');
    }
}
