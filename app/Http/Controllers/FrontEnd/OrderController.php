<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\newOrder;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Payments\PaymobController;
use App\Http\Controllers\Payments\PaypalController;
use App\Http\Controllers\Payments\StripeController;
use App\Models\Branch;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PaymentCustomer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Status;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Carbon::setLocale('ar');
        $orders = Order::where('user_id', Auth::id())->latest();
        $statuses = Status::all();
        $branches = Branch::all();
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
            $order->update([
                'client_viewed' => true,
                'client_status_viewed' => true,
            ]);
        }
        return view('frontend.user.orders', compact('orders', 'statuses', 'branches'));
    }

    public function payments(Request $request) {
        Carbon::setLocale('ar');
        $payments = Payment::where('user_id', Auth::id())->latest();
        if($request->order_id) {
            $payments = $payments->where('order_id', 'like', '%' . $request->order_id .'%');
        }
        if($request->transaction_id) {
            $payments = $payments->where('transaction_id', 'like', '%' . $request->transaction_id .'%');
        }
        $payments = $payments->paginate(10);
        return view('frontend.user.payments', compact('payments'));
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
            'payment_method' => 'required|in:cod,paypal,paymob,fawry,stripe',
            'type' => 'required|in:inhouse,online',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_phone' => 'required',
            'city_id' => 'required|exists:cities,id',
        ];
        $mesages = [
            'payment_method.required' => 'يجب أختيار عملية الدفع',
            'payment_method.in' => 'يوجد خطأ ما فى اختيار عملية الدفع',
            'type.required' => 'نوع الطلب مطلوب',
            'type.in' => 'يجب أختيار نوع من الموجودين بالفعل',
            'customer_name.required' => 'الأسم مطلوب',
            'customer_address.required' => 'العنوان مطلوب',
            'customer_phone.required' => 'الهاتف مطلوب',
            'city_id.required' => 'المدينة مطلوبة',
        ];
        if($request['type'] == 'inhouse' && $request['payment_method'] == 'cod') {
            unset($rules['customer_name']);
            unset($rules['customer_address']);
            unset($rules['customer_phone']);
            unset($rules['city_id']);
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

    public function get_total_price(Request $request) {
        $carts = $request->session()->get('carts');
        $city = City::find($request->city_id);
        if(isset($carts) && count($carts) > 0) {
            $grand_total = [];
            foreach ($carts as $cart) {
                $product = Product::find($cart['product_id']);
                if($product) {
                    if(isset($cart['amount'])) {
                        array_push($grand_total, $product->price_after_discount * $cart['amount']);
                    }
                    if(isset($cart['sizes'])) {
                        if(count($cart['sizes']) > 0) {
                            foreach ($cart['sizes'] as $size) {
                                $productVariant = ProductVariant::find($size['size_id']);
                                if($productVariant) {
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
                                    array_push($grand_total, $productVariant->price_after_discount * $extra['extra_amount']);
                                }
                            }
                        }
                    }
                }
            }
            $grand_total = array_reduce($grand_total,
            function($acc, $current) {return $acc + $current;});
            if($request['type'] == 'online') {
                $grand_total = $grand_total + $city['price'];
            }
            return $grand_total;
        }
    }

    public function checkout(Request $request) {
        $request->session()->put('payment_method', $request['payment_method']);
        $cents = $this->get_total_price($request)  * 100;
        if($this->validateOrder($request)) {
            return $this->validateOrder($request);
        }
        if($request['payment_method'] == 'cod') {
            // Store Order
            return $this->store($request);
        } else {
            // Store Order
            $this->store($request);
        }
        if($request['payment_method'] == 'paymob') {
            $paymobController = new PaymobController();
            return $paymobController->payment($request, $cents);
        } else if($request['payment_method'] == 'paypal') {
            $paypalController = new PaypalController();
            return $paypalController->processPaypal($request);

        } else if($request['payment_method'] == 'fawry') {

        } else if($request['payment_method'] == 'stripe') {
            $stripeController = new StripeController();
            return $stripeController->payment($request,$cents);
        }
    }

    public function store(Request $request)
    {
        $carts = $request->session()->get('carts');
        if(isset($carts) && count($carts) > 0) {
            $branch = Product::find($carts[array_key_first($carts)]['product_id'])->category->branch;
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
                $request->session()->put('order_id', $order->id);
                $request->session()->forget('carts');
                $request->session()->forget('order_type');
                if($request->session()->get('payment_method') == 'cod') {
                    return view('frontend.order_confirmed', compact('order'));
                } else {
                    return $order;
                }
            } else {
                return redirect()->back()->with('error', 'يجب تعيين حالة افتراضية');
            }
        } else {
            return redirect(route('frontend.home'));
        }
    }

    public function order_confirmed(Request $request,Order $order) {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $payment_session_id = $request->session()->get('payment_session_id');
        Carbon::setLocale('ar');
        if(isset($payment_session_id)) {
            $session = $stripe->checkout->sessions->retrieve($payment_session_id);
            if($session['payment_status'] == 'paid') {
                $order->paid = 1;
                $order->save();
            }
            $request->session()->forget('payment_session_id');
            $request->session()->forget('order_id');
            $request->session()->forget('payment_method');
            return view('frontend.order_confirmed', compact('order'));
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
    public function show(Request $request, Order $order) {
        $order->update([
            'client_viewed' => true,
            'client_status_viewed' => true,
        ]);
        return view('frontend.user.order_show', compact('order'));
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
