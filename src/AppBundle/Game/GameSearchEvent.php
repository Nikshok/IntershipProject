<?php

namespace AppBundle\Game;

use AppBundle\Entity\User;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;
use AppBundle\Game\Listeners\GameSearchListener;
class GameSearchEvent
{
    private $doctrine;
    private $messageDriver;
    private $user;
    private $value;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver, User $user, $value = null)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;
        $this->user = $user;
        $this->value = $value;

        $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
        $listener->fire($user);
    }

    public function gameSearchEvent() {

    }
}