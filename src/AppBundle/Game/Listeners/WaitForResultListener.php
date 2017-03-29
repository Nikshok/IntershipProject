<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class WaitForResultListener extends GameAbstractListener
{
    public function fire(User $user)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 12])->getPhrase();
        $this->messageDriver->addMessage($user, $phrase);
    }
}