<?php

namespace AppBundle\Services\Game\Listeners;

use AppBundle\Entity\Game;
use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services\MessageDriver;

class GameFoundListener
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
    public function gameFoundListener(Game $game)
    {
        $phraseStatus = $this->em->getRepository(Phrase::class)->findOneBy([
            'categoryId' => 3]);
        $firstUser = $this->em->getRepository(User::class)->findOneBy([
            'id' => $game->getFirstUserId()]);
        $secondUser = $this->em->getRepository(User::class)->findOneBy([
            'id' => $game->getSecondUserId()]);
        if (isset($firstUser)) {
            $this->messageSender->sendMessage($firstUser, $phraseStatus);
        }
        if (isset($secondUser)) {
            $this->messageSender->sendMessage($secondUser, $phraseStatus);
        }
    }
}