<?php

namespace AppBundle\Game\Listeners;
use AppBundle\Entity\User;

class GameTopListener extends GameAbstractListener
{
    public function fire(User $user, String $message) {
        $this->messageDriver->addMessage($user, $message);
    }

}