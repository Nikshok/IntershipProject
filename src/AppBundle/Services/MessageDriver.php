<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Services\MessageSenders\MessageSenderVK;
use Symfony\Component\HttpFoundation\Request;

class MessageDriver
{
    private $senders = [
        User::PROVIDER_VK => null,
        'User::PROVIDER_TG' => null,
    ];

    public function __construct(MessageSenderVK $sender_vk_service)
    {
        $this->senders[User::PROVIDER_VK] = $sender_vk_service;
    }

    public function sendMessage(User $user, $message)
    {
        foreach ($this->senders as $provider => $sender) {
            if ($user->getProviderId() == $provider) {
                $sender->sendMessage($user, $message);
            }
        }
    }
}