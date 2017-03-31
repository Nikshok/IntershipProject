<?php

namespace AppBundle\Game;


use AppBundle\Game\Listeners\GameErrorListener;

class GameErrorEvent extends GameAbstractEvent
{
    public function fire(User $user, $param = null)
    {
        if (!$user) {
            return false;
        }

        $event = new GameErrorListener($this->doctrine, $this->messageDriver);
        $event->fire($user);
    }
}