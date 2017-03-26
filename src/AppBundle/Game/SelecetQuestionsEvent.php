<?php

namespace AppBundle\Game;



use AppBundle\Entity\Game;
use AppBundle\Entity\Question;

class SelecetQuestionsEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {


        $questions = $this->doctrine->getRepository(Question::class)->findRandomQuestions(10);

        print_r($questions);

        if (!$questions) {
            return false;
        }


//
//        $event = new SendQuestionListener($this->doctrine, $this->messageDriver);
//        $event->fire($question);
//
//        $question->setDateBegin(new \DateTime());
//        $question->setStatus(1);
//
//        $em = $this->doctrine->getManager();
//        $em->persist($question);
//        $em->flush();
//
//        $event = new GetResultEvent($this->doctrine, $this->messageDriver);
//        $event->fire($game);
    }
}