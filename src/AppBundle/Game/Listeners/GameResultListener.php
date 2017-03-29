<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameResultListener extends GameAbstractListener
{
    public function fire(User $user, int $firstCounter, int $firstTime, int $secondCounter, int $secondTime)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 13])->getPhrase();

        $phrase = str_replace("[firstRightAnswerCounter]", $firstCounter, $phrase);
        $phrase = str_replace("[secondRightAnswerCounter]", $secondCounter, $phrase);
        $phrase = str_replace("[firstTime]", $firstTime, $phrase);
        $phrase = str_replace("[secondTime]", $secondTime, $phrase);

        $this->messageDriver->addMessage($user, $phrase);
    }
}