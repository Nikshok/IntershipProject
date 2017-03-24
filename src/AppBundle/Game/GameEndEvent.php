<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameEndListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameEndEvent extends GameAbstractEvent
{

    public function fire(Game $game, User $user)
    {

        $em = $this->doctrine->getManager();
        $game->setStatus(5);
        $game->setWinner($user);

        if ($game->getFirstUser() == $user) {

            $loserUser = $game->getSecondUser();

        } else {

            $loserUser = $game->getFirstUser();

        }

        $em->flush();
        $listener = new GameEndListener($this->doctrine, $this->messageDriver);
        $listener->end($game, $loserUser);
    }
}