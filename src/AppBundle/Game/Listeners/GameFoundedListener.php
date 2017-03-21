<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameFoundedListener
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
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 3]);
        $user1 = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getFirstUserId()]);
        $user2 = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getSecondUserId()]);
        $this->messageDriver->addMessage($user1, $phrase->getPhrase());
        $this->messageDriver->addMessage($user2, $phrase->getPhrase());
        $confirm = new GameConfirmationListener($this->doctrine, $this->messageDriver);
        $confirm->confirm($user1);
    }

}