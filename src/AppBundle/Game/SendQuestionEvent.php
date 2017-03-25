<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\SendQuestionListener;

class SendQuestionEvent extends GameAbstractEvent
{
    public function fire(User $user, Game $game)
    {
        $question = $this->doctrine->getRepository(GameQuestion::class)->findNextQuestionForSending($user, $game);

        if (!$question) {
            return false;
        }

        $event = new SendQuestionListener($this->doctrine, $this->messageDriver);
        $event->fire($question);

        $question->setDateBegin(new \DateTime());
        $question->setStatus(1);

        $em = $this->doctrine->getManager();
        $em->persist($question);
        $em->flush();

        $event = new GetResultEvent($this->doctrine, $this->messageDriver);
        $event->fire($game);
    }
}