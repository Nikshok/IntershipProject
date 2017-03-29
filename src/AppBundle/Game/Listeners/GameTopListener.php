<?php

namespace AppBundle\Game\Listeners;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameTopListener extends GameAbstractListener
{
    public function fire(User $user, array $users) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 11]);
        $message = $phrase->getPhrase();
        foreach ($users as $user) {
            $message .= $user->getFullName()."<br>";
        }
        $this->messageDriver->addMessage($user, $message);
    }

}