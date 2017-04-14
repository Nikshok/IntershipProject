<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameCapitulateListener extends GameAbstractListener
{

    public function fire(Game $game, User $winnerUser, User $loserUser)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 6]);
        $this->messageDriver->addMessage($winnerUser, $phrase->getPhrase());

        $listener = new GameEndListener($this->doctrine, $this->messageDriver);
        $listener->fire($game, $loserUser);
    }

}