<?php

namespace AppBundle\Services\MessageSenders;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class MessageSenderVK
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

    public function sendMessage(User $user, $message)
    {
        $parameters = [
            'user_id' => $user->getImportId(),
            'random_id' => mt_rand(1, 99999),
            'peer_id' => $this->peer_id,
            'message' => $message,
            'access_token' => $this->access_token,
            'v' => $this->v,
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
    }
}