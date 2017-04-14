<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameDeadHeatListener;
use AppBundle\Game\Listeners\GameEndListener;

class GameEndEvent extends GameAbstractEvent
{

    public function fire(Game $game, User $user = null)
    {

        $em = $this->doctrine->getManager();
        $game->setStatus(Game::GAME_OVER);

        if (is_null($user)) {

            $em->flush();
            $listener = new GameDeadHeatListener($this->doctrine, $this->messageDriver);
            $listener->fire($game);

        } else {

            $game->setWinner($user);

            if ($game->getFirstUser() == $user) {

                $loserUser = $game->getSecondUser();

            } else {

                $loserUser = $game->getFirstUser();

            }

            $em->flush();
            $listener = new GameEndListener($this->doctrine, $this->messageDriver);
            $listener->fire($game, $loserUser);

        }
    }
}