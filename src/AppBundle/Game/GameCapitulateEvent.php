<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;

class GameCapitulateEvent extends GameAbstractEvent
{

    public function fire(User $user, $value = null)
    {
            $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
                ->where('(g.firstUser = :user OR g.secondUser = :user) AND g.status = 3')
                ->setParameter('user', $user)
                ->getQuery();

            $findGame = $query->setMaxResults(1)->getOneOrNullResult();

            if (isset($findGame)) {
                $checkUser = $findGame->getFirstUser();

                if ($checkUser == $user) {

                    $winnerUser = $findGame->getSecondUser();

                } else {

                    $winnerUser = $findGame->getFirstUser();
                }

                $listener = new GameEndEvent($this->doctrine, $this->messageDriver);
                $listener->fire($findGame, $winnerUser);
            }
        }
}