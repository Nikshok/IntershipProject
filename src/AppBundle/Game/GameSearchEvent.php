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
            ->where('(g.firstUser = :user OR g.secondUser = :user) AND (g.status IN (1,2,3))')
            ->setParameter('user', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (!isset($findGame)) {

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

                $em = $this->doctrine->getManager();
                $findGame = new Game();
                $findGame->setFirstUser($user);
                $findGame->setStatus(Game::GAME_IN_SEARCH);
                $em->persist($findGame);
                $em->flush();
                $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
                $listener->fire($findGame);

            }
        }
    }

}