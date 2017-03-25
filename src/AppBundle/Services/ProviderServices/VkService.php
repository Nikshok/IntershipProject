<?php

namespace AppBundle\Services\ProviderServices;

use AppBundle\Entity\User;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class VkService
{
    private $access_token;

    public function __construct($access_token_vk)
    {
        $this->access_token = $access_token_vk;
    }

    public function sendMessage(User $user, $message)
    {
        $client = new Client();

        $url = 'https://api.vk.com/method/photos.getMessagesUploadServer';

        $parameters = [
            'access_token' => $this->access_token,
        ];

        $response = $client->request('POST', $url, ['query' => $parameters]);

        if (!$response = json_decode($response->getBody()->getContents(), true)) {
            return false;
        }

        if (!isset($response['response']['upload_url'])) {
            return false;
        }

        $url = $response['response']['upload_url'];

        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'photo',
                    'contents' => fopen(__DIR__ . '/test.jpg', 'r'),
                ],
            ]
        ]);

        if (!$response = json_decode($response->getBody()->getContents(), true)) {
            return false;
        }

        $url = 'https://api.vk.com/method/photos.saveMessagesPhoto';

        $parameters = [
            'photo' => stripslashes($response['photo']),
            'server' => $response['server'],
            'hash' => $response['hash'],
            'access_token' => $this->access_token,
        ];

        $response = $client->request('POST', $url, ['query' => $parameters]);

        if (!$response = json_decode($response->getBody()->getContents(), true)) {
            return false;
        }

        $url = 'https://api.vk.com/method/messages.send';

        $parameters = [
            'user_id' => $user->getImportId(),
            'message' => $message,
            'attachment' => 'photo' . $response['response'][0]['owner_id'] . '_' . $response['response'][0]['pid'],
            'access_token' => $this->access_token,
        ];

        $client->request('POST', $url, ['query' => $parameters]);

    }

    public function getUserInfo($user_import_id)
    {
        $url = 'https://api.vk.com/method/users.get';

        $parameters = [
            'user_ids' => $user_import_id,
            'fields' => 'photo_200_orig',
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