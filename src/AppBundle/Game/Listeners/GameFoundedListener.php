<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;

class GameFoundedListener extends GameAbstractListener
{

    public function fire(Game $game)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 3]);

        $user1 = $game->getFirstUser();
        $user2 = $game->getSecondUser();

        $phrase1 = str_replace("[user]", $user1->getFullName(), $phrase->getPhrase());
        $phrase2 = str_replace("[user]", $user2->getFullName(), $phrase->getPhrase());

        $this->messageDriver->addMessage($user1, $phrase2);
        $this->messageDriver->addMessage($user2, $phrase1);

        $confirm = new GameConfirmationListener($this->doctrine, $this->messageDriver);
        $confirm->fire($user1);
    }

}