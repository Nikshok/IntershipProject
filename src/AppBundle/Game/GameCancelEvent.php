<?php
namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameRemoveListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameCancelEvent extends GameAbstractEvent
{

    public function fire(User $user, $value = null){

        $query = $this->doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('g.firstUser = :firstUser AND (g.status = 1 OR g.status = 2)')
            ->setParameter('firstUser', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {

            $em = $this->doctrine->getManager();
            $em->remove($findGame);
            $em->flush();
            $listener = new GameRemoveListener($this->doctrine, $this->messageDriver);
            $listener->remove($user);

        }
    }

}