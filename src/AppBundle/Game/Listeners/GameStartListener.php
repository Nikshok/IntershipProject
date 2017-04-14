<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;

class GameStartListener extends GameAbstractListener
{

    public function fire(Game $game)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 4]);

        $user1 = $game->getFirstUser();
        $user2 = $game->getSecondUser();

        $this->messageDriver->addMessage($user1, $phrase->getPhrase());
        $this->messageDriver->addMessage($user2, $phrase->getPhrase());

    }
}