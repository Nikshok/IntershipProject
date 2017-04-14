<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameEndListener extends GameAbstractListener
{

    public function fire(Game $game, User $loserUser)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 7]);

        $user = $game->getWinner();

        $this->messageDriver->addMessage($user, $phrase->getPhrase());

        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 8]);

        $this->messageDriver->addMessage($loserUser, $phrase->getPhrase());
    }
}