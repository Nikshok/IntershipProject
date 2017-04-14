<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;

class GameDeadHeatListener extends GameAbstractListener
{

    public function fire(Game $game)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 9]);

        $this->messageDriver->addMessage($game->getFirstUser(), $phrase->getPhrase());
        $this->messageDriver->addMessage($game->getSecondUser(), $phrase->getPhrase());
    }
}