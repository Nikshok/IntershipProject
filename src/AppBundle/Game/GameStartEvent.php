<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameStartListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameStartEvent
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

    }

    public function gameSearchEvent(Registry $doctrine, User $user)
    {
        $game = $doctrine->getRepository(Game::class)->findOneBy([
            'firstUserId' => $user->getId(),
            'statusId' => 2
        ]);

        if(isset($game)) {
            $em = $doctrine->getManager();
            $game->setStatusId(3);
            $em->flush();
            $listener = new GameStartListener($this->doctrine, $this->messageDriver);
            $listener->fire($game);

        }

    }
}