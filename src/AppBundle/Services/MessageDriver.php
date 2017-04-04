<?php

namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Services\ProviderServices\TgService;
use AppBundle\Services\ProviderServices\VkService;
use Doctrine\ORM\EntityManager;

class MessageDriver
{
    private $em = null;

    private $senderServices = [
        User::PROVIDER_VK => null,
        User::PROVIDER_TG => null,
    ];

    private $messages = [];

    public function __construct(VkService $vkService, TgService $tgService, EntityManager $em)
    {
        $this->em = $em;
        $this->senderServices[User::PROVIDER_TG] = $tgService;
        $this->senderServices[User::PROVIDER_VK] = $vkService;
    }

    public function addMessage(User $user, $message)
    {
        $this->messages[$user->getId()][] = $message;
    }

    public function execute()
    {
        if (!isset($this->messages)) {
            return false;
        }

        foreach ($this->messages as $userId => $messages) {
            $user = $this->em->getRepository(User::class)->findOneBy(['id' => $userId]);

            $message = implode($messages, "\n");

            $this->senderServices[$user->getProviderId()]->sendMessage($user, $message);
        }

        $this->messages = [];
    }
}