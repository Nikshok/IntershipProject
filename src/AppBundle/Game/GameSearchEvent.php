<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameFoundedListener;
use AppBundle\Game\Listeners\GameSearchListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

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

    }

    /**
     * @param Registry $doctrine
     * @param User $user
     */
    public function gameSearchEvent(Registry $doctrine, User $user)
    {
        $query = $doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('g.firstUserId != :firstUserId AND g.secondUserId IS NULL')
            ->setParameter('firstUserId', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {

            $em = $doctrine->getManager();
            $findGame->setSecondUserId($user);
            $findGame->setStatusId(2);
            $listener = new GameFoundedListener($this->doctrine, $this->messageDriver);
            $listener->fire($findGame);
            $em->flush();

        } else {

            $query = $doctrine->getRepository(Game::class)->createQueryBuilder('g')
                ->where('g.firstUserId = :firstUserId AND g.secondUserId IS NULL')
                ->setParameter('firstUserId', $user)
                ->getQuery();
            $findStartedGame = $query->setMaxResults(1)->getOneOrNullResult();

            if (!isset($findStartedGame)) {

                $em = $doctrine->getManager();
                $findGame = new Game();
                $findGame->setFirstUserId($user);
                $findGame->setStatusId(1);
                $em->persist($findGame);
                $em->flush();
                $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
                $listener->fire($findGame);
            }

        }
    }
}