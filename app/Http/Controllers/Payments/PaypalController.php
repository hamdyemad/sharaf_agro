<?php


namespace App\Http\Controllers\Payments;
use Srmklive\PayPal\Services\PayPal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function createpaypal()
   {
    return view('paypal_view');
   }
    public function processPaypal(Request $request)
    {
        $provider = new PayPal(config('paypal'));
        $token = $provider->getAccessToken();
        $data = [
            'intent' => 'CAPTURE',
            "application_context" => [
                "return_url" => route('processSuccess'),
                "cancel_url" => route('processCancel'),
            ],
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '100.00'
                    ]
                ]
            ]
        ];
        $order = $provider->createOrder($data);
        if(isset($order['status']) && $order['status'] == 'CREATED') {
            foreach ($order['links'] as $link) {
                if($link['rel'] == 'approve') {
                    return redirect($link['href']);
                }
            }
        } else {
            return "Not Created";
        }

    }


    public function processSuccess(Request $request)
    {
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        return $response;
        if($response['status'] == 'COMPLETED') {
            return "تم الدفع بنجاح";
        } else {
            return "المعاملة فشلت";
        }

    }

    public function processCancel(Request $request)
    {
        return $request->all();
    }
}
