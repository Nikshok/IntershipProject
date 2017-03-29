<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameStartListener;

class GameStartEvent extends GameAbstractEvent
{

    public function fire(User $user, $value = null)
    {
        $game = $this->doctrine->getRepository(Game::class)->findOneBy([
            'firstUser' => $user->getId(),
            'status' => 2
        ]);

        if (isset($game)) {

            $em = $this->doctrine->getManager();
            $game->setStatus(3);
            $em->flush();
            $listener = new GameStartListener($this->doctrine, $this->messageDriver);
            $listener->fire($game);

            $event = new SelectQuestionsEvent($this->doctrine, $this->messageDriver);
            $event->fire($game);

        }
    }
}