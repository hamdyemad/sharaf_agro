<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NexmoController extends Controller
{
    public function send_sms() {
        // Nexmo::message()->send([
        //     'to'   => '+201152059120',
        //     'from' => '+201152059120',
        //     'text' => 'أمك قرعة :D'
        // ]);
    }
}
