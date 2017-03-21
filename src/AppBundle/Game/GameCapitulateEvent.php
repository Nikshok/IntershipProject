<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameCapitulateListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameCapitulateEvent
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

    public function gameCapitulateEvent(Registry $doctrine, User $user) {

        $query = $doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('(g.firstUserId = :user OR g.secondUserId = :user) AND g.statusId = 3')
            ->setParameter('user', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {
            $em = $doctrine->getManager();
            $findGame->setStatusId(4);
            $checkUser = $findGame->getFirstUserId();
            if ($checkUser == $user) {

                $winnerUser = $findGame->getSecondUserId();
                $loserUser = $findGame->getFirstUserId();

            } else {

                $winnerUser = $findGame->getFirstUserId();
                $loserUser = $findGame->getSecondUserId();
            }
            $findGame->setWinnerId($winnerUser);
            $em->flush();
            $listener = new GameCapitulateListener($this->doctrine, $this->messageDriver);
            $listener->capitulate($findGame, $winnerUser, $loserUser);
        }
    }
}