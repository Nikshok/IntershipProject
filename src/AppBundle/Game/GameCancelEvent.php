<?php
namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameRemoveListener;
use AppBundle\Game\Listeners\GameSearchListener;

class GameCancelEvent extends GameAbstractEvent
{

    public function fire(User $user, $value = null)
    {

        $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('(g.firstUser = :user AND g.secondUser IS NULL) AND g.status = 1')
            ->setParameter('user', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {

            $em = $this->doctrine->getManager();
            $em->remove($findGame);
            $em->flush();

            $listener = new GameRemoveListener($this->doctrine, $this->messageDriver);
            $listener->fire($user);

        } else {

            $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
                ->where('g.firstUser = :user AND g.status = 2')
                ->setParameter('user', $user)
                ->getQuery();

            $findGame = $query->setMaxResults(1)->getOneOrNullResult();

            if (isset($findGame)) {

                $em = $this->doctrine->getManager();
                $findGame->setFirstUser($findGame->getSecondUser());
                $findGame->setSecondUser();
                $findGame->setStatus(1);
                $em->flush();

                $listener = new GameRemoveListener($this->doctrine, $this->messageDriver);
                $listener->fire($user);
                $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
                $listener->fire($findGame);

            } else {

                $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
                    ->where('g.secondUser = :user AND g.status = 2')
                    ->setParameter('user', $user)
                    ->getQuery();

                $findGame = $query->setMaxResults(1)->getOneOrNullResult();

                if (isset($findGame)) {
                    $em = $this->doctrine->getManager();
                    $findGame->setSecondUser();
                    $findGame->setStatus(1);
                    $em->flush();

                    $listener = new GameRemoveListener($this->doctrine, $this->messageDriver);
                    $listener->fire($user);
                    $listener = new GameSearchListener($this->doctrine, $this->messageDriver);
                    $listener->fire($findGame);
                }
            }
        }
    }

}