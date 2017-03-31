<?php

namespace AppBundle\Game\Listeners;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameTopListener extends GameAbstractListener
{
    public function fire(User $user, array $users) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 11]);
        $message = $phrase->getPhrase()."<br>";

        foreach ($users as $value) {

                $message .= $value[0]->getFullName() . " " . $value[1];

        }

        $this->messageDriver->addMessage($user, $message);
    }

}