<?php

namespace AppBundle\Services\MessageSenders;

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
        $parameters = [
            'user_id' => $user->getImportId(),
            'message' => $message,
            'access_token' => $this->access_token,
        ];

        $url = 'https://api.vk.com/method/messages.send';

        $client = new Client();

        $client->request('POST', $url, ['query' => $parameters]);

        $url = "https://pu.vk.com/c638125/upload.php?act=do_add&mid=87305277&aid=-64&gid=142517072&hash=7614cf4c65951d3ea70eedf5ca8d951d&rhash=be24453aa143a7ba33951463f5e90b41&swfupload=1&api=1&mailphoto=1";

        $response = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'photo',
                    'contents' => fopen('/home/nikshok/Pictures/test.jpg', 'r'),
                ],
            ]
        ]);

        print_r($response->getBody()->getContents());

    }

    public function getUserInfo($user_import_id)
    {
        $url = 'https://api.vk.com/method/users.get';

        $parameters = [
            'user_ids' => $user_import_id,
            'fields' => 'photo_200',
        ];

        $client = new Client();

        $json_response = $client->request('POST', $url, ['query' => $parameters]);

        $response = json_decode($json_response->getBody()->getContents(), true);

        return [
            'first_name' => $response['response'][0]['first_name'],
            'last_name' => $response['response'][0]['last_name'],
            'avatar' => $response['response'][0]['photo_200'],
        ];
    }
}