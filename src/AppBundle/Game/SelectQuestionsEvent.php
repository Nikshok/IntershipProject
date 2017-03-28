<?php

namespace AppBundle\Game;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\Question;

class SelectQuestionsEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {
        if ($this->doctrine->getRepository(GameQuestion::class)->findBy(['game' => $game]) != null) {
            return false;
        }

        $questions = $this->doctrine->getRepository(Question::class)->findRandomQuestions(10);

        if (!$questions) {
            return false;
        }

        $em = $this->doctrine->getManager();

        foreach ($questions as $question) {

            $gameQuestion = new GameQuestion();

            $gameQuestion->setGame($game);
            $gameQuestion->setQuestion($question);
            $gameQuestion->setUser($game->getFirstUser());

            $em->persist($gameQuestion);

        }

        foreach ($questions as $question) {

            $gameQuestion = new GameQuestion();

            $gameQuestion->setGame($game);
            $gameQuestion->setQuestion($question);
            $gameQuestion->setUser($game->getSecondUser());

            $em->persist($gameQuestion);
        }

        $em->flush();

        $event = new SendQuestionEvent($this->doctrine, $this->messageDriver);
        $event->fire($game->getFirstUser(), $game);
        $event->fire($game->getSecondUser(), $game);
    }
}