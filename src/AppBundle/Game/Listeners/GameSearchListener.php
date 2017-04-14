<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;

class GameSearchListener extends GameAbstractListener
{

    public function fire(Game $game)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 1]);

        $user = $game->getFirstUser();

        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }


}