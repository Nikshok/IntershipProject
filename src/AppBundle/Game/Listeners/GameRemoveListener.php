<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameRemoveListener extends GameAbstractListener
{

    public function fire(User $user) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 10]);
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }

}