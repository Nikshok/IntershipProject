<?php

namespace AppBundle\Game\Listeners;


use AppBundle\Entity\GameQuestion;

class SendQuestionListener extends GameAbstractListener
{
    public function fire(GameQuestion $question)
    {
        $this->messageDriver->addMessage($question->getUser(), $question->getQuestion()->getQuestion());
    }
}