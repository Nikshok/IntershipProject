<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameSearchListener extends GameAbstractListener
{

    public function fire(Game $game) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 1]);
        $user = $game->getFirstUser();
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }


}