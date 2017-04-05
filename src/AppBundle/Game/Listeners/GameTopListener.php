<?php

namespace AppBundle\Game\Listeners;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameTopListener extends GameAbstractListener
{
    public function fire(User $user, array $users) {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 11]);
        $message = $phrase->getPhrase()."\n";

        foreach ($users as $key => $value) {

                $message .= ($key+1) . " " . $value[0]->getFullName() . " " .  $value[1] . "\n";

        }

        $this->messageDriver->addMessage($user, $message);
    }

}