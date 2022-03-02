<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('statuses.index');
        Carbon::setLocale('ar');
        $statuses = Status::latest();
        if($request->name) {
           $statuses->where('name', 'like', '%' . $request->name . '%');
        }
        $statuses = $statuses->paginate(10);
        return view('orders.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('statuses.create');
        return view('orders.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('statuses.create');
        $creation = [
            'name' => $request->name
        ];
        if($request->has('default_val')) {
            if($request->default_val == 'on') {
                $creation['default_val'] = 1;
                $status = Status::where('default_val', 1)->first();
                if($status) {
                    $status->default_val = 0;
                    $status->save();
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:statuses,name'
        ], [
            'name.required' => 'الحالة مطلوبة',
            'name.unique' => 'الأسم هذا موجود بالفعل',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', 'يوجد خطأ ما');
        }
        Status::create($creation);
        return redirect()->back()->with('success', 'تم انشاء الحالة بنجاح');

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
    public function edit(Status $status)
    {
        $this->authorize('statuses.edit');
        return view('orders.statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        $this->authorize('statuses.edit');
        $creation = [
            'name' => $request->name
        ];
        if($request->has('default_val')) {
            if($request->default_val == 'on') {
                $creation['default_val'] = 1;
                $status = Status::where('default_val', 1)->first();
                if($status) {
                    $status->default_val = 0;
                    $status->save();
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('statuses', 'name')->ignore($status->id)]
        ], [
            'name.required' => 'الحالة مطلوبة',
            'name.unique' => 'الأسم هذا موجود بالفعل'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', 'يوجد خطأ ما');
        }
        $status->update($creation);
        return redirect()->back()->with('info', 'تم تعديل الحالة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $this->authorize('statuses.destroy');
        Status::destroy($status->id);
        return redirect()->back()->with('success', 'تمت ازالة الحالة بنجاح');
    }
}
