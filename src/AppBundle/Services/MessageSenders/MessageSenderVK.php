<?php

namespace AppBundle\Services\MessageSenders;

use AppBundle\Entity\User;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class MessageSenderVK
{
    private $access_token;

    public function __construct($access_token_vk)
    {
        $this->access_token = $access_token_vk;
    }

    public function sendMessage(User $user, $message)
    {
        $parameters = [
            'user_id' => $user->getImportId(),
            'message' => $message,
            'access_token' => $this->access_token,
        ];

        $url = 'https://api.vk.com/method/messages.send';

        $curl = curl_init('');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_REFERER, 'http://google.com');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters));

        curl_exec($curl);

        curl_close($curl);

        $url = "https://pu.vk.com/c638125/upload.php?act=do_add&mid=87305277&aid=-64&gid=142517072&hash=7614cf4c65951d3ea70eedf5ca8d951d&rhash=be24453aa143a7ba33951463f5e90b41&swfupload=1&api=1&mailphoto=1";

        $client = new Client();

        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'photo',
                    'contents' => fopen('/home/nikshok/Pictures/test.jpg', 'r'),
                ],
            ]
        ]);

        print_r($response);

    }
}