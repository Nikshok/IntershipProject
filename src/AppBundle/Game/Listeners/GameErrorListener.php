<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameErrorListener extends GameAbstractListener
{

    public function fire(User $user)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 14])->getPhrase();

        $this->messageDriver->addMessage($user, $phrase);
    }

}