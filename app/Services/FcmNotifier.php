<?php 

namespace App\Services;

use Exception;

class FCMNotifier
{
    private $access_token;
    private $url = 'https://fcm.googleapis.com/fcm/send';
    private $headers = [
        'Content-Type: application/json'
    ];
    
    public function __construct()
    {
        $this->access_token = "AAAAVz0oWUQ:APA91bGCK_cS1_8mAYLqyOb2_YAqMdKZduEAolGPs5LALRthTxWIv6fKMfTvAcWb3yE0i0i7pJgW9NhrnD44lLSdgBVsOWDjONO4NpyTSlYAfVRMzJXWsWrImIYJVtdl12tZxdYgm8I_";
        $this->headers[] = 'Authorization: key=' . $this->access_token;
    }
    
    public function notify($registration_ids, $title, $body, $data = [])
    {
        $data = [
            'registration_ids' => $registration_ids,
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'data' => $data
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            throw new Exception($errorMessage);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
