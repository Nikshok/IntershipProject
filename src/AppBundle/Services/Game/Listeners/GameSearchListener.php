<?php

namespace AppBundle\Services\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;
use AppBundle\Services\MessageSenders\MessageSenderVK;

class GameSearchListener
{
    protected $em;
    protected $messageSender;

    public function __construct(\Doctrine\ORM\EntityManager $em, MessageSenderVK $messageSender)
    {
        $this->em = $em;
        $this->messageSender = $messageSender;
    }

    public function gameSearchListener($user, $id)
    {
        $phraseStatus = $this->em->getRepository(Phrase::class)->findOneBy([
            'categoryId' => $id]);
        $gameUser = $this->em->getRepository(User::class)->findBy([
            'id' => $user]);
        $this->messageSender->sendMessage($gameUser, $phraseStatus);
    }
}