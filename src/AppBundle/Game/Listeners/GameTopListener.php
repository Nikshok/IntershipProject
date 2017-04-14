<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameTopListener extends GameAbstractListener
{
    public function fire(User $user, array $users)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 11]);

        $message = $phrase->getPhrase()."<br>";

        foreach ($users as $key => $value) {
                $message .= ($key+1) . "&#8419; " . $value[0]->getFullName() . " " .  $value[1] . "<br>";
        }

        $this->messageDriver->addMessage($user, $message);
    }

}