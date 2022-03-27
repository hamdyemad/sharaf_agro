<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Business;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{

    public function values(Request $request) {
        return  [
            'name' => $request->name,
            'expense_for' => $request->expense_for,
            'phone' => $request->phone,
            'price' => $request->price,
            'notes' => $request->notes,
            'type' => $request->type,
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('expenses.index');
        if($request->has('type')) {

            Carbon::setLocale(app()->getLocale());
            $business = Business::where('id', $request->type)->first();
            $expenses = Expense::latest();
            $expenses->where('type', $request->type);
            if($request->name) {
                $expenses = $expenses->where('name', 'like', '%' . $request->name . '%');
            }
            if($request->expense_for) {
                $expenses = $expenses->where('expense_for', 'like', '%' . $request->expense_for . '%');
            }
            if($request->phone) {
                $expenses = $expenses->where('phone', 'like', '%' . $request->phone . '%');
            }
            if($request->price) {
                $expenses = $expenses->where('price', 'like', '%' . $request->price . '%');
            }
            $expenses = $expenses->paginate(10);
            return view('business.expenses.index', compact('expenses', 'business'));
        } else {
            return redirect()->back()->with('error', translate('there is something error'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('expenses.create');
        if($request->has('type')) {
            $business = Business::where('id', $request->type)->first();
            return view('business.expenses.create', compact('business'));
        } else {
            return redirect()->back()->with('error', translate('there is something error'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $this->authorize('expenses.create');
        if($request->has('type')) {
            $business = Business::where('id', $request->type)->first();
            Expense::create($this->values($request));
            return redirect()->back()->with('success', translate('created successfully'));
        } else {
            return redirect()->back()->with('error', translate('there is something error'));
        }
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
    public function edit(Request $request,Expense $expense)
    {
        $this->authorize('expenses.edit');
        if($request->has('type')) {
            $business = Business::where('id', $request->type)->first();
            return view('business.expenses.edit', compact('expense', 'business'));
        }
        else {
            return redirect()->back()->with('error', translate('there is something error'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $this->authorize('expenses.edit');
        if($request->has('type')) {
            $business = Business::where('id', $request->type)->first();
            $expense->update($this->values($request));
            return redirect()->back()->with('info', translate('updated successfully'));
        } else {
            return redirect()->back()->with('error', translate('there is something error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('expenses.destroy');
        Expense::destroy($expense->id);
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
