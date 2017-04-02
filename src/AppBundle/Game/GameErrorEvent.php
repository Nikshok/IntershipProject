<?php

namespace AppBundle\Game;


use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameErrorListener;

class GameErrorEvent extends GameAbstractEvent
{
    public function fire(User $user, $param = null)
    {
        if (!$user) {
            return false;
        }

        $listener = new GameErrorListener($this->doctrine, $this->messageDriver);
        $listener->fire($user);
    }
}