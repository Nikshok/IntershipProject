<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Services\MessageSenders\MessageSenderVK;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class MessageDriver
{
    private $em = null;

    private $senders = [
        User::PROVIDER_VK => null,
        'User::PROVIDER_TG' => null,
    ];

    private $messages = [];

    public function __construct(MessageSenderVK $sender_vk_service, EntityManager $em)
    {
        $this->em = $em;

        $this->senders[User::PROVIDER_VK] = $sender_vk_service;
    }

    public function addMessage(User $user, $message)
    {
        $this->messages[$user->getId()][] = $message;
    }

    public function execute()
    {
        foreach ($this->messages as $userId => $messages) {
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => $userId]);
            foreach ($this->senders as $provider => $sender) {
                if ($user->getProviderId() == $provider) {
                    $message = implode($messages, '<br>');
                    $sender->sendMessage($user, $message);
                }
            }
        }
    }
}