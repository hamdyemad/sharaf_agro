<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait FirebaseNotify {

    public function send_notify($token, $title, $body) {
        $url = "https://fcm.googleapis.com/v1/projects/". env('FIREBASE_PROJECT_ID') ."/messages:send";
        $response = Http::post($url)->headers([
            'Authorization' => 'Bearer'
        ]);
        $data = [
            'registration_ids' => [
                $token
            ],
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default'
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . env('FIREBASE_SERVER_KEY'),
            'content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        return $response;
    }
}
