<?php

namespace AppBundle\Services\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Entity\Game;
use AppBundle\Services\MessageDriver;

class GameSearchListener
{
    protected $em;
    protected $messageSender;

    public function __construct(\Doctrine\ORM\EntityManager $em, MessageDriver $messageSender)
    {
        $this->em = $em;
        $this->messageSender = $messageSender;
    }

    /**
     * @param Game $game
     */
    public function gameSearchListener(Game $game)
    {
        $phraseStatus = $this->em->getRepository(Phrase::class)->findOneBy([
            'categoryId' => 1]);
        $firstUser = $this->em->getRepository(User::class)->findOneBy([
            'id' => $game->getFirstUserId()]);
        if (isset($firstUser)) {
            $this->messageSender->sendMessage($firstUser, $phraseStatus);
        }
    }
}