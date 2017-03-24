<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameStartListener
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

    public function fire(Game $game) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 4]);
        $user1 = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getFirstUser()]);
        $user3 = $this->doctrine->getRepository(User::class)->findOneBy(['id' => 3]);
        $user2 = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getSecondUser()]);
        $this->messageDriver->addMessage($user1, $phrase->getPhrase());
        $this->messageDriver->addMessage($user2, $phrase->getPhrase());
        //$this->messageDriver->addMessage($user3, $phrase->getPhrase());

    }
}