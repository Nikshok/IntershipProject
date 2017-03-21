<?php
namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameRemoveListener;
use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameCancelEvent
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

    public function gameCancelEvent(Registry $doctrine, User $user){

        $query = $doctrine->getRepository(Game::class)->createQueryBuilder('g')
            ->where('g.firstUserId = :firstUserId AND (g.statusId = 1 OR g.statusId = 2)')
            ->setParameter('firstUserId', $user)
            ->getQuery();

        $findGame = $query->setMaxResults(1)->getOneOrNullResult();

        if (isset($findGame)) {

            $em = $doctrine->getManager();
            $em->remove($findGame);
            $em->flush();
            $listener = new GameRemoveListener($this->doctrine, $this->messageDriver);
            $listener->remove($user);

        }
    }

}