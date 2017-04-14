<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameConfirmationListener extends GameAbstractListener
{

    public function fire(User $user)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 5]);
        $this->messageDriver->addMessage($user, $phrase->getPhrase());
    }

}