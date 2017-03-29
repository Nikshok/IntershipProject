<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\Phrase;
use AppBundle\Entity\User;

class GameResultListener extends GameAbstractListener
{
    public function fire(User $user, int $counter, int $time)
    {
        $phrase = $this->doctrine->getRepository(Phrase::class)->findOneBy(['categoryId' => 12])->getPhrase();

        $phrase = str_replace("[rightAnswerCounter]", $counter, $phrase);
        $phrase = str_replace("[secondAnswerCounter]", $counter, $phrase);
        $phrase = str_replace("[firstTime]", $time, $phrase);
        $phrase = str_replace("[secondTime]", $time, $phrase);

        $this->messageDriver->addMessage($user, $phrase);
    }
}