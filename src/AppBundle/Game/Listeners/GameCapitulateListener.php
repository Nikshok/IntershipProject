<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameCapitulateListener extends GameAbstractListener
{

    public function capitulate(Game $game, User $winnerUser, User $loserUser) {

        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 6]);
        $user = $this->doctrine->getRepository(User::class)->findOneBy(['id' => $game->getFirstUser()]);
        $this->messageDriver->addMessage($winnerUser, $phrase->getPhrase());

    }

}