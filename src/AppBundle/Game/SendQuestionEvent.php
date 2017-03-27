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
        if ($game->getStatus() != Game::GAME_IN_ACTION) {
            return false;
        }

        $event = new GameResultEvent($this->doctrine, $this->messageDriver);
        $event->fire($game);

        $question = $this->doctrine->getRepository(GameQuestion::class)->findNextQuestionForSending($user, $game);

        if (!$question) {
            return false;
        }

        $answers = $this->doctrine->getRepository(Answer::class)->findBy(['questionId' => $question->getQuestion()]);

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