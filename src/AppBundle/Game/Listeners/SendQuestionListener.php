<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Entity\GameQuestion;

class SendQuestionListener extends GameAbstractListener
{
    public function fire(GameQuestion $question, $shuffleAnswers)
    {
        $this->messageDriver->addMessage($question->getUser(), $question->getQuestion()->getQuestion());

        foreach ($shuffleAnswers as $key =>$answer) {
            $this->messageDriver->addMessage($question->getUser(), $key + 1 .') ' . $answer->getAnswer());
        }
    }
}