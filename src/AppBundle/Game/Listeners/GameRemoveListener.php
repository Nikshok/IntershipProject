<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;

class GameRemoveListener extends GameAbstractListener
{

    public function fire(Game $game)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 10]);

        $this->messageDriver->addMessage($game->getFirstUser(), $phrase->getPhrase());

        if (!is_null($game->getSecondUser())) {
            $this->messageDriver->addMessage($game->getSecondUser(), $phrase->getPhrase());
        }
    }

}