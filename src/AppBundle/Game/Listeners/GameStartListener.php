<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Game\SelectQuestionsEvent;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameStartListener extends GameAbstractListener
{

    public function fire(Game $game) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 4]);
        $user1 = $game->getFirstUser();
        $user2 = $game->getSecondUser();
        $this->messageDriver->addMessage($user1, $phrase->getPhrase());
        $this->messageDriver->addMessage($user2, $phrase->getPhrase());

        $event = new SelectQuestionsEvent($this->doctrine, $this->messageDriver);
        $event->fire($game);

    }
}