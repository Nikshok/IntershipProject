<?php

namespace AppBundle\Services\MessageSenders;

use AppBundle\Entity\User;
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
    }
}