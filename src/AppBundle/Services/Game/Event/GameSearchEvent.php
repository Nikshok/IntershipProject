<?php

namespace AppBundle\Services\Game\Event;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Services\Game\Listeners\GameSearchListener;

class GameSearchEvent
{
    protected $em;
    protected $searchEvent;

    public function __construct(\Doctrine\ORM\EntityManager $em, GameSearchListener $searchEvent)
    {
        $this->em = $em;
        $this->searchEvent = $searchEvent;
    }

    public function searchGame(User $user)
    {
        $findGame = $this->em->getRepository(Game::class)->findBy([
            'firstUserId' => $user->getImportId()
        ]);

        if (isset($findGame)) {

            $query = $this->em->createQuery(
                'SELECT p
            FROM AppBundle:Game p
            WHERE p.firstUserId != :first_user_id AND p.secondUserId IS NULL')
                ->setParameter('first_user_id', $user->getProviderId());


            $findGame = $query->setMaxResults(1)->getOneOrNullResult();
            if ($findGame) {
                $this->searchEvent->gameSearchListener($findGame->getFirstUserId(), 3);
                $this->searchEvent->gameSearchListener($findGame->getSecondUserId(), 3);
                $this->em->flush();
            } else {
                $findGame = new Game();
                $findGame->setFirstUserId($user->getProviderId());
                $findGame->setStatusId(1);
                $this->searchEvent->gameSearchListener($findGame->getFirstUserId(), 1);
                $this->em->persist($findGame);
                $this->em->flush();
            }
        }
    }
}