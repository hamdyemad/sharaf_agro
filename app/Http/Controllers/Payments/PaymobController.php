<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymobController extends Controller
{

    public function pay_page($iframe, $payment_token) {
        return redirect("https://accept.paymobsolutions.com/api/acceptance/iframes/$iframe?payment_token=$payment_token");
    }
    public function token() {
        $response = Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymobsolutions.com/api/auth/tokens', [
            'api_key' => env('PAY_MOB_KEY')
        ]);
        return $response->json()['token'];
    }

    public function make_order_and_get_id($data) {
        $response_final = Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymob.com/api/ecommerce/orders', $data);
        return $response_final->json()['id'];
    }
    public function payment_request($data) {
        $response = Http::withHeaders([
            'content-type' => 'application/json'
        ])->post('https://accept.paymob.com/api/acceptance/payment_keys', $data);
        return $response->json();
    }

    public function payment(Request $request, $total_price_in_cents) {
        $carts = $request->session()->get('carts');
        $items = [];
        $amounts = 0;
        foreach ($carts as $cart) {
            if(isset($cart['amount'])) {
                $amounts += $cart['amount'];
            } else {
                foreach ($cart['sizes'] as $size) {
                    $amounts += intval($size['size_amount']);
                }
            }
            array_push($items, [
                "name" => $cart['product_id'],
                "amount_cents" => $cart['total_price'],
                "description" => "description",
                "quantity" =>  $amounts
            ]);
        }
        $city = City::find($request->city_id);
        // Make Order To Paymob
        $paymobInvoiceId =  $this->make_order_and_get_id([
            "auth_token" => $this->token(),
            "delivery_needed" => "false",
            "amount_cents" => $total_price_in_cents,
            "currency" => "EGP",
            "items" => $items
        ]);
        // Make Payment Request
        $token_to_pay =  $this->payment_request([
            'auth_token' => $this->token(),
            'amount_cents' => $total_price_in_cents,
            'expiration' => 6000,
            'order_id' => $paymobInvoiceId,
            'currency' => 'EGP',
            'integration_id' => env('PAY_MOB_CARD_INTEGRATION'),
            'lock_order_when_paid' => false,
            'billing_data' => [
                "apartment" =>  "7",
                "email" =>  "razereng0@gmail.com",
                "floor" =>  "7",
                "first_name" =>  $request->customer_name,
                "street" =>  "Street",
                "building" =>  "0",
                "phone_number" =>  $request->customer_phone,
                "shipping_method" =>  "PKG",
                "postal_code" =>  "0",
                "city" =>  $city->name,
                "country" =>  $city->country->name,
                "last_name" =>  $request->customer_name,
                "state" =>  "Utah"
            ]
        ])['token'];
        // Return redirection page with iframe
        return $this->pay_page(env('PAY_MOB_IFRAME'),$token_to_pay);
    }

    public function callback(Request $request) {
        $data = $request->all();
        return $data;
        ksort($data);
        $hmac = $data['hmac'];
        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success'
        ];
        $connectingString = '';
        foreach ($data as $key => $value) {
            if(in_array($key, $array)) {
                $connectingString .= $value;
            }
        }
        $hashed = hash_hmac('sha512', $connectingString, '95167539C11A603ECD2EAFD2C9B5FAC7');
        if($hashed == $hmac) {
            if($data['success'] == 'true') {
                return $data;
            } else {
                return "العملية فشلت";
            }
        } else {
            return redirect(route('frontend.payment'))->with('error', 'يوجد خطأ ما');
        }
    }
}
