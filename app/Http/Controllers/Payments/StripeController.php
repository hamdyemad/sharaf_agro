<?php

namespace App\Http\Controllers\Payments;

use Stripe\Stripe;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\CustomerCard;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentCustomer;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StripeController extends Controller
{
    public function payment(Request $request,$total_price_in_cents) {
        $paymentCustomer =  PaymentCustomer::where('user_id', Auth::id())->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $order = Order::find(request()->session()->get('order_id'));
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $currency = Currency::where('default', 1)->first();
        if($paymentCustomer) {
            $customer = $stripe->customers->retrieve($paymentCustomer->customer_id);
        } else {
            $customer = $stripe->customers->create([
                'address' => [
                    'city' => 'cairo',
                    'country' => 'egypt',
                    'line1' => '7st ahmed shbeb from ahmed ragab'
                ],
                'email' => 'asd@asd.com',
                'name' => 'kareem emad',
                'phone' => '01152059120',
            ]);
            PaymentCustomer::create([
                'user_id' => Auth::id(),
                'customer_id' => $customer['id'],
                'customer_name' => $customer['name'],
                'customer_phone' => $customer['phone'],
                'customer_city' => $customer['address']['city'],
                'customer_country' => $customer['address']['country'],
                'customer_address' => $customer['address']['line1'],
            ]);
        }
        $line_items = [
            'price_data' => [
                'currency' => $currency->code,
                'product_data' => [
                    'name' => '_'
                ],
                'unit_amount' => $total_price_in_cents,
            ],
            'quantity' => 1
        ];

        $session =  \Stripe\Checkout\Session::create([
            'customer' => $customer['id'],
            'line_items' => [$line_items],
            'mode' => 'payment',
            'success_url' => route('frontend.order_confirmed', $order). '?session_id=success_payment',
            'cancel_url' => route('frontend.payment').'?session_id=cancel_payment',
        ]);
        Payment::create([
            'user_id' => Auth::id(),
            'transaction_id' => $session['id'],
            'order_id' =>  $request->session()->get('order_id'),
            'amount' => $total_price_in_cents
        ]);
        $request->session()->put('payment_session_id', $session['id']);
        return redirect($session->url);
    }
}
