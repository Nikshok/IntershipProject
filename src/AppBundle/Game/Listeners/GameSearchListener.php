<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameSearchListener
{
    private $doctrine;
    private $messageDriver;
    private $user;
    private $value;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;

<<<<<<< HEAD
    }

    public function fire(User $user)
    {
=======

    }

    public function fire(Game $game) {
>>>>>>> 06be8f91fcd680269878daa26b3fddc20f7cf783
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 1]);
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getFirstUserId()]);
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }

}