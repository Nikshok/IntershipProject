<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameEndListener
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

    public function end(Game $game, User $loserUser) {

        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 7]);
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getWinner()]);
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 8]);
        $this->messageDriver->addMessage($loserUser, $phrase->getPhrase());

    }
}