<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerBalanceExport;
use App\Http\Controllers\Controller;
use App\Models\CustomerBalance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class CustomerBalanceController extends Controller
{
    public function index(Request $request) {
        $this->authorize('balances.index');
        $balances = CustomerBalance::latest();
        $customers = User::where('type', 'user')->where('id', '!=', Auth::id())->get();
        if($request->user_id) {
            $balances->where('user_id', $request->user_id);
        }
        if($request->balance) {
            $balances->where('balance', 'like', '%' . $request->balance . '%');
        }
        $balances = $balances->paginate(10);
        return view('users.customers.balances.index', compact('balances', 'customers'));
    }

    public function create(Request $request) {
        $this->authorize('balances.create');
        $customers = User::where('type', 'user')->where('id', '!=', Auth::id())->get();
        return view('users.customers.balances.create', compact('customers'));
    }

    public function edit(Request $request, CustomerBalance $balance) {
        $this->authorize('balances.edit');
        return view('users.customers.balances.edit', compact('balance'));
    }

    public function store(Request $request) {
        $this->authorize('balances.create');
        $creation = [
            'user_id' => $request->user_id,
            'balance' => $request->balance
        ];
        $rules = [
            'user_id' => ['required', 'unique:customers_balance,user_id', 'exists:users,id'],
            'balance' => ['required', 'integer']
        ];
        $messages = [
            'user_id.required' => 'الشركة مطلوبة',
            'user_id.unique' => 'تم اضافة رصيد للشركة هذه من قبل',
            'user_id.exists' => 'الشركة غير موجودة',
            'balance.required' => 'رصيد الشركة مطلوب',
            'balance.integer' => 'يجب أن يكون الرصيد رقم'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
        }
        CustomerBalance::create($creation);
        return redirect()->to(route('balances.index'))->with('success', 'تم انشاء رصيد الشركة بنجاح');

    }
    public function update(Request $request, CustomerBalance $balance) {
        $this->authorize('balances.edit');
        $creation = [
            'balance' => $request->balance
        ];
        $rules = [
            'balance' => ['required', 'integer']
        ];
        $messages = [
            'balance.required' => 'رصيد الشركة مطلوب',
            'balance.integer' => 'يجب أن يكون الرصيد رقم'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->with('error', 'يوجد خطأ ما')->withInput($request->all());
        }
        $balance->update($creation);
        return redirect()->to(route('balances.index'))->with('success', 'تم تعديل رصيد الشركة بنجاح');
    }

    public function export(Request $request) {
        $balances = CustomerBalance::latest();
        if($request->user_id) {
            $balances->where('user_id', $request->user_id);
        }
        if($request->balance) {
            $balances->where('balance', 'like', '%' . $request->balance . '%');
        }
        $balances = $balances->get();
        return Excel::download(new CustomerBalanceExport($balances),'balances.xlsx');
    }

    public function destroy(Request $request, CustomerBalance $balance) {
        $this->authorize('balances.destroy');
        CustomerBalance::destroy($balance->id);
        return redirect()->back()->with('success', 'تم ازالة رصيد الشركة بنجاح');
    }
}
