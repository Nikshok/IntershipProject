<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameEndListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameEndEvent
{
    private $doctrine;
    private $messageDriver;
    private $user;
    private $value;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver, User $user, $value = null)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;
        $this->user = $user;
        $this->value = $value;

    }

    public function gameEndEvent(Registry $doctrine, Game $game, User $user)
    {

        $em = $doctrine->getManager();
        $game->setStatusId(5);
        $game->setWinnerId($user);

        if ($game->getFirstUserId() == $user) {

            $loserUser = $game->getSecondUserId();

        } else {

            $loserUser = $game->getFirstUserId();

        }

        $em->flush();
        $listener = new GameEndListener($this->doctrine, $this->messageDriver);
        $listener->end($game, $loserUser);
    }
}