<?php

namespace App\Http\Controllers\Admin;

use App\Events\changeOrderStatus;
use App\Events\newOrder;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Status;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('orders.index');
        Carbon::setLocale(app()->getLocale());
        $orders = Order::latest();
        $statuses = Status::all();
        $branches = Branch::all();
        if(Auth::user()->type !== 'admin') {
            $orders = $orders->where('branch_id', Auth::user()->branch_id);
        }
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
            $order->update(['viewed' => true]);
        }
        return view('orders.index', compact('orders', 'statuses', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('orders.create');
        $status = Status::where('default_val', 1)->first();
        $countries = Country::where('active', '1')->get();
        if($status) {
            if(Auth::user()->type !== 'admin') {
                $products = Product::whereHas('category', function($query) {
                    return $query->where('branch_id', Auth::user()->branch_id);
                })->latest()->get();
            } else {
                $products = null;
            }
            $branches = Branch::orderBy('name')->get();
            return view('orders.create', compact('products', 'branches', 'countries'));

        } else {
            return redirect()->back()->with('error', translate('a default status must be set'));
        }
    }

    public function validateOrder($request) {
        $rules = [
            'type' => 'required|in:inhouse,online',
            'branch_id' => 'required|exists:branches,id',
            'products_search' => 'required'
        ];
        $mesages = [
            'type.required' => translate('the type is required'),
            'branch_id.required' => translate('the branch is required'),
            'branch_id.exists' => translate('the branch should be exists'),
            'type.in' => translate('you should choose a type from the stock'),
            'products_search.required' => translate('you should choose a minmum 1 product'),
        ];
        if($request->type == 'online') {
            $rules['customer_name'] = 'required';
            $rules['customer_address'] = 'required';
            $rules['customer_phone'] = 'required';
            $rules['city_id'] = 'required';
            $mesages['customer_name.required'] = translate('the name is required');
            $mesages['customer_address.required'] = translate('the address is required');
            $mesages['customer_phone.required'] =translate('the phone is required');
            $mesages['city_id.required'] = translate('the city is required');
        }
        if($request->products) {
            foreach ($request->products as $productId => $productObj) {
                if(isset($productObj['amount'])) {
                    $rules["products.$productId.amount"] = ['required','integer','min:1'];
                    $mesages["products.$productId.amount.required"] = translate('the amount is required');
                    $mesages["products.$productId.amount.min"] = translate('the amount should be at least 1');
                }
                if(isset($productObj['variants'])) {
                    foreach ($productObj['variants'] as $variantId => $variant) {
                        $rules["products.$productId.variants.$variantId.amount"] = ['required', 'integer','min:1'];
                        $mesages["products.$productId.variants.$variantId.amount.required"] = translate('the amount is required');
                        $mesages["products.$productId.variants.$variantId.amount.min"] = translate('the amount should be at least 1');
                    }
                }
            }
        }
        $validator = Validator::make($request->all(),$rules, $mesages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', translate('there is something error'));
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
        $city = City::find($request->city_id);
        if($city) {
            $request['shipping'] = $city->price;
        }
        $this->authorize('orders.create');
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $creation = [
                'type' => $request->type,
                'branch_id' => $request->branch_id,
                'status_id' => $status->id,
                'city_id' => $request->city_id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'total_discount' => $request->total_discount,
                'shipping' => $request->shipping,
                'grand_total' => 0
            ];
            if($this->validateOrder($request)) {
                return $this->validateOrder($request);
            }
            $grand_total = [];
            $order = Order::create($creation);
            StatusHistory::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status_id' => $status->id
            ]);
            foreach ($request->products as $productId => $productObj) {
                $product = Product::find($productId);
                if($product) {
                    if(isset($productObj['amount'])) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'price' => $product->price_after_discount,
                            'qty' => $productObj['amount'],
                            'total_price' => $product->price_after_discount * $productObj['amount']
                        ]);
                        array_push($grand_total, $product->price_after_discount * $productObj['amount']);
                    }
                    if(isset($productObj['variants'])) {
                        foreach ($productObj['variants'] as $variantId => $variant) {
                            $productVariant = ProductVariant::find($variantId);
                            if($productVariant) {
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'variant' => $productVariant->variant,
                                    'variant_type' => $productVariant->type,
                                    'price' => $productVariant->price_after_discount,
                                    'qty' => $variant['amount'],
                                    'total_price' => $productVariant->price_after_discount * $variant['amount']
                                ]);
                                array_push($grand_total, $productVariant->price_after_discount * $variant['amount']);
                            }
                        }
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});
            $order->grand_total = (($grand_total + $request->shipping) - $creation['total_discount']);
            $order->save();
            event(new newOrder([
                'order' => $order,
                'products_count' => $order->order_details->groupBy('product_id')->count(),
                'status' => $order->status
            ]));
            return redirect()->back()->with('success', translate('created successfully'));
        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
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
        $order->update(['viewed' => true]);
        Carbon::setLocale(app()->getLocale());
        $statuses_history = StatusHistory::where('order_id', $order->id)->latest()->get();
        return view('orders.show', compact('order', 'statuses_history'));
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
        $status = Status::where('default_val', 1)->first();
        $countries = Country::where('active', '1')->get();
        if($order->city) {
            $cities = City::where('country_id', $order->city->country_id)->get();
        } else {
            $cities = [];
        }
        if($status) {
        $products = Product::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        return view('orders.edit', compact('order', 'branches', 'products', 'countries', 'cities'));

        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
        }
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
        $city = City::find($request->city_id);
        if($city) {
            $request['shipping'] = $city->price;
        }
        $status = Status::where('default_val', 1)->first();
        if($status) {
            $creation = [
                'type' => $request->type,
                'branch_id' => $request->branch_id,
                'status_id' => $status->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'total_discount' => $request->total_discount,
                'shipping' => $request->shipping,
                'grand_total' => 0
            ];
            if($this->validateOrder($request)) {
                return $this->validateOrder($request);
            }
            $grand_total = [];
            $order->update($creation);
            OrderDetail::where('order_id', $order->id)->delete();
            foreach ($request->products as $productId => $productObj) {
                $product = Product::find($productId);
                if($product) {
                    if(isset($productObj['amount'])) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'price' => $product->price_after_discount,
                            'qty' => $productObj['amount'],
                            'total_price' => $product->price_after_discount * $productObj['amount']
                        ]);
                        array_push($grand_total, $product->price_after_discount * $productObj['amount']);
                    }
                    if(isset($productObj['variants'])) {
                        foreach ($productObj['variants'] as $variantId => $variant) {
                            $productVariant = ProductVariant::find($variantId);
                            if($productVariant) {
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'variant' => $productVariant->variant,
                                    'variant_type' => $productVariant->type,
                                    'price' => $productVariant->price_after_discount,
                                    'qty' => $variant['amount'],
                                    'total_price' => $productVariant->price_after_discount * $variant['amount']
                                ]);
                                array_push($grand_total, $productVariant->price_after_discount * $variant['amount']);
                            }
                        }
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});
            $order->grand_total = ($grand_total + $request->shipping) - $creation['total_discount'];
            $order->save();
            return redirect()->back()->with('info', translate('updated successfully'));
        } else {
            return redirect()->back()->with('error', translate('you should choose a default status'));
        }
    }

    public function updateStatus(Request $request) {
        $order = Order::find($request->order_id);
        if($order) {
            $order->update([
                'status_id' => $request->status_id,
                'client_status_viewed' => 0
            ]);
            StatusHistory::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'status_id' => $order->status_id
            ]);
            event(new changeOrderStatus([
                'user_id' => Auth::id(),
                'status_id' => $request->status_id,
                'order' => $order,
                'status_name' => $order->status->name
            ]));
            return response()->json(['msg' => translate('updated successfully'), 'status' => true]);
        }
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
        Order::destroy($order->id);
        return redirect()->back()->with('success', translate('deleted successfully'));
    }
}
