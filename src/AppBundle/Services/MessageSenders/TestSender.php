<?php

namespace AppBundle\Services\MessageSenders;

use Symfony\Component\HttpFoundation\Request;

class TestSender
{
    private $peer_id;
    private $access_token;
    private $v;

    public function __construct($peer_id, $access_token, $v)
    {
        $this->peer_id = $peer_id;
        $this->access_token = $access_token;
        $this->v = $v;
    }

    public function sendMessage($user_id, $message)
    {
        $parameters = [
            'user_id' => $user_id,
            'random_id' => mt_rand(1, 99999),
            'peer_id' => $this->peer_id,
            'message' => $message,
            'access_token' => $this->access_token,
            'v' => $this->v,
        ];

        $url = 'https://api.vk.com/method/messages.send?' . http_build_query($parameters);

        $curl = curl_init('');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_REFERER, 'http://google.com');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:51.0) Gecko/20100101 Firefox/51.0');

        $data = curl_exec($curl);

        curl_close($curl);
    }
}
