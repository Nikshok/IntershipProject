<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameFoundedListener;
use AppBundle\Game\Listeners\GameSearchListener;

class GameSearchEvent extends GameAbstractEvent
{
    public function fire(User $user, $value = null)
    {
        $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('g.firstUser != :firstUser AND g.secondUser IS NULL')
            ->setParameter('firstUser', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {

            $em = $this->doctrine->getManager();
            $findGame->setSecondUser($user);
            $findGame->setStatus(2);
            $em->flush();
            $listener = new GameFoundedListener($this->doctrine, $this->messageDriver);
            $listener->fire($findGame);

        } else {

            $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
                ->where('(g.firstUser = :user OR g.secondUser = :user) AND (g.status = 2 OR g.status = 3)')
                ->setParameter('user', $user)
                ->getQuery();

            $findGame = $query->setMaxResults(1)->getOneOrNullResult();

            if (!isset($findGame)) {

                $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
                    ->where('g.firstUser = :firstUser AND g.secondUser IS NULL')
                    ->setParameter('firstUser', $user)
                    ->getQuery();
                $findStartedGame = $query->setMaxResults(1)->getOneOrNullResult();

                if (!isset($findStartedGame)) {

                    $em = $this->doctrine->getManager();
                    $findGame = new Game();
                    $findGame->setFirstUser($user);
                    $findGame->setStatus(1);
                    $em->persist($findGame);
                    $em->flush();
                    $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
                    $listener->fire($findGame);
                }

            }
        }
    }
}