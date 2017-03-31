<?php

namespace AppBundle\Game;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\SendQuestionListener;

class SendQuestionEvent extends GameAbstractEvent
{
    public function fire(User $user, Game $game)
    {
        $event = new GameResultEvent($this->doctrine, $this->messageDriver);

        if ($event->fire($game, $user) != false) {
            return false;
        }

        $question = $this->doctrine->getRepository(GameQuestion::class)->findNextQuestionForSending($user, $game);

        if (!$question) {
            return false;
        }

        $answers = $question->getQuestion()->getAnswers();

        $shuffleAnswers = [];

        foreach ($answers as $answer) {
            $shuffleAnswers[] = $answer;
        }

        shuffle($shuffleAnswers);

        foreach ($shuffleAnswers as $key => $answer){
            if($answer->getIsCorrect() == 1) {
                $question->setAnswerParam($key + 1);
            }
        }

        $question->setDateBegin(new \DateTime());
        $question->setStatus(1);

        $em = $this->doctrine->getManager();
        $em->persist($question);
        $em->flush();

        $event = new SendQuestionListener($this->doctrine, $this->messageDriver);
        $event->fire($question, $shuffleAnswers);

    }
}