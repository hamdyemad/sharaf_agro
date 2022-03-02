<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\newOrder;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Status;
use App\Models\StatusHistory;
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
    public function validateOrder($request) {
        $rules = [
            'type' => 'required|in:inhouse,online'
        ];
        $mesages = [
            'type.required' => 'نوع الطلب مطلوب',
            'type.in' => 'يجب أختيار نوع من الموجودين بالفعل'
        ];
        if($request->type == 'online') {
            $rules['customer_name'] = 'required';
            $rules['customer_address'] = 'required';
            $rules['customer_phone'] = 'required';
            $rules['city_id'] = 'required';
            $mesages['customer_name.required'] = 'الأسم مطلوب';
            $mesages['customer_address.required'] = 'العنوان مطلوب';
            $mesages['customer_phone.required'] = 'الهاتف مطلوب';
            $mesages['city_id.required'] = 'المدينة مطلوبة';
        }

        $validator = Validator::make($request->all(),$rules, $mesages);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
            ->withInput($request->all())
            ->with('error', 'يوجد خطأ ما');
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
        $carts = $request->session()->get('carts');
        if(isset($carts) && count($carts) > 0) {
            $branch = Product::find($request->session()->get('carts')[0]['product_id'])->category->branch;
            $status = Status::where('default_val', 1)->first();
            $creation = [
                'type' => $request->type,
                'user_id' => Auth::id(),
                'branch_id' => $branch->id,
                'status_id' => $status->id,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes' => $request->notes,
                'grand_total' => 0
            ];
            if($request->type == 'online') {
                $city = City::find($request->city_id);
                if($city) {
                    $request['shipping'] = $city->price;
                }
                $creation['city_id'] = $request->city_id;
                $creation['shipping'] = $request->shipping;
            }
            if($this->validateOrder($request)) {
                return $this->validateOrder($request);
            }
            if($status) {
                $grand_total = [];
                $order = Order::create($creation);
                StatusHistory::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'status_id' => $status->id
                ]);
                foreach ($carts as $cart) {
                    $product = Product::find($cart['product_id']);
                    if($product) {
                        if(isset($cart['amount'])) {
                            OrderDetail::create([
                                'order_id' => $order->id,
                                'product_id' => $product->id,
                                'price' => $product->price_after_discount,
                                'qty' => $cart['amount'],
                                'total_price' => $product->price_after_discount * $cart['amount']
                            ]);
                            array_push($grand_total, $product->price_after_discount * $cart['amount']);
                        }
                        if(isset($cart['sizes'])) {
                            if(count($cart['sizes']) > 0) {
                                foreach ($cart['sizes'] as $size) {
                                    $productVariant = ProductVariant::find($size['size_id']);
                                    if($productVariant) {
                                        OrderDetail::create([
                                            'order_id' => $order->id,
                                            'product_id' => $product->id,
                                            'variant' => $productVariant->variant,
                                            'variant_type' => $productVariant->type,
                                            'price' => $productVariant->price_after_discount,
                                            'qty' => $size['size_amount'],
                                            'total_price' => $productVariant->price_after_discount * $size['size_amount']
                                        ]);
                                        array_push($grand_total, $productVariant->price_after_discount * $size['size_amount']);
                                    }
                                }
                            }
                        }
                        if(isset($cart['extras'])) {
                            if(count($cart['extras']) > 0) {
                                foreach ($cart['extras'] as $extra) {
                                    $productVariant = ProductVariant::find($extra['extra_id']);
                                    if($productVariant) {
                                        OrderDetail::create([
                                            'order_id' => $order->id,
                                            'product_id' => $product->id,
                                            'variant' => $productVariant->variant,
                                            'variant_type' => $productVariant->type,
                                            'price' => $productVariant->price_after_discount,
                                            'qty' => $extra['extra_amount'],
                                            'total_price' => $productVariant->price_after_discount * $extra['extra_amount']
                                        ]);
                                        array_push($grand_total, $productVariant->price_after_discount * $extra['extra_amount']);
                                    }
                                }
                            }
                        }
                    }
                }
                $grand_total = array_reduce($grand_total,
                function($acc, $current) {return $acc + $current;});
                $order->grand_total = (($grand_total + $request->shipping));
                $order->save();
                event(new newOrder([
                    'order' => $order,
                    'products_count' => $order->order_details->groupBy('product_id')->count(),
                    'status' => $order->status
                ]));
                $request->session()->forget('carts');
                $request->session()->forget('order_type');
                return view('frontend.order_confirmed', compact('order'));
            } else {
                return redirect()->back()->with('error', 'يجب تعيين حالة افتراضية');
            }
        } else {
            return redirect(route('frontend.home'));
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
