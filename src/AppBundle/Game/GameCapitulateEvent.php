<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameCapitulateListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameCapitulateEvent extends GameAbstractEvent
{

    public function fire(User $user, $value = null) {

        $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('(g.firstUser = :user OR g.secondUser = :user) AND g.status = 3')
            ->setParameter('user', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {
            $em = $this->doctrine->getManager();
            $findGame->setStatus(4);
            $checkUser = $findGame->getFirstUser();
            if ($checkUser == $user) {

                $winnerUser = $findGame->getSecondUser();
                $loserUser = $findGame->getFirstUser();

            } else {

                $winnerUser = $findGame->getFirstUser();
                $loserUser = $findGame->getSecondUser();
            }
            $findGame->setWinner($winnerUser);
            $em->flush();
            $listener = new GameCapitulateListener($this->doctrine, $this->messageDriver);
            $listener->fire($findGame, $winnerUser, $loserUser);
        }
    }
}