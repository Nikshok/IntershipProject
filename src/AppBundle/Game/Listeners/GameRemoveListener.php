<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameRemoveListener
{
    private $doctrine;
    private $messageDriver;
    private $user;
    private $value;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;

    }

    public function remove(User $user) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 10]);
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }

}