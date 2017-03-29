<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\User;

class GameAnswerEvent extends GameAbstractEvent
{
    public function fire(User $user, int $param)
    {
        $game = $this->doctrine->getRepository(Game::class)->findActiveGameByUser($user);

        if (!$game) {
            return false;
        }

        $question = $this->doctrine->getRepository(GameQuestion::class)->findCurrentQuestion($user, $game);

        if (!$question) {
            return false;
        }

        if ($question->getAnswerParam() == $param) {
            $question->setAnswerChecker(1);
        } else {
            $question->setAnswerChecker(2);
        }

        $question->setDateEnd(new \DateTime());

        $em = $this->doctrine->getManager();
        $em->persist($question);
        $em->flush();

        $event = new SendQuestionEvent($this->doctrine, $this->messageDriver);
        $event->fire($user, $game);
    }
}