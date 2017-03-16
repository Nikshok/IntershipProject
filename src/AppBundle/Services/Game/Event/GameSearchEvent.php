<?php

namespace AppBundle\Services\Game\Event;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Services\Game\Listeners\GameSearchListener;
use AppBundle\Services\Game\Listeners\GameFoundListener;

class GameSearchEvent
{
    protected $em;
    protected $searchEvent;

    public function __construct(\Doctrine\ORM\EntityManager $em,  GameFoundListener $foundListener, GameSearchListener $searchListener)
    {
        $this->em = $em;
        $this->searchListener = $searchListener;
        $this->foundListener = $foundListener;
    }

    public function searchGame(User $user)
    {
        $findGame = $this->em->getRepository(Game::class)->findBy([
            'firstUserId' => $user->getId()
        ]);

        if (isset($findGame)) {

            $query = $this->em->createQuery(
                'SELECT p
            FROM AppBundle:Game p
            WHERE p.firstUserId != :first_user_id AND p.secondUserId IS NULL')
                ->setParameter('first_user_id', $user->getProviderId());


            $findGame = $query->setMaxResults(1)->getOneOrNullResult();
            if ($findGame) {
                $this->foundListener->gameFoundListener($findGame);
                $this->em->flush();
            } else {
                $newGame = new Game();
                $newGame->setFirstUserId($user->getProviderId());
                $newGame->setStatusId(1);
                $this->searchListener->gameSearchListener($newGame);
                $this->em->persist($newGame);
                $this->em->flush();
            }
        }
    }
}