<?php

namespace AppBundle\Services\ProviderServices;

use AppBundle\Entity\User;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class TgService
{
    private $access_token;

    public function __construct($access_token_tg)
    {
        $this->access_token = $access_token_tg;
    }

    public function sendMessage(User $user, $message)
    {
        $client = new Client();

        $url = 'https://api.telegram.org/bot'.$this->access_token.'/sendMessage';

        $parameters = [
            'chat_id' => $user->getImportId(),
            'text' => $message,
        ];

        $client->request('POST', $url, ['query' => $parameters]);

    }

    public function getUserInfo($user_import_id)
    {
        $url = 'https://api.telegram.org/bot'.$this->access_token.'/getChat';

        $parameters = [
            'chat_id' => $user_import_id,
        ];

        $client = new Client();

        $response = $client->request('POST', $url, ['query' => $parameters]);

        if (!$response = json_decode($response->getBody()->getContents(), true)) {
            return false;
        }

        $info = [
            'first_name' => '',
            'last_name' => '',
            'avatar' => '',
        ];

        if (isset($response['response'][0]['first_name']) && isset($response['response'][0]['last_name']) && isset($response['response'][0]['photo_200_orig'])) {
            $info['first_name'] = $response['response'][0]['first_name'];
            $info['last_name'] = $response['response'][0]['last_name'];
            $info['avatar'] = $response['response'][0]['photo_200_orig'];
        }

        return $info;
    }

}