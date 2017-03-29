<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Game\Listeners\GameRemoveListener;
use AppBundle\Game\Listeners\GameResultListener;
use AppBundle\Game\Listeners\WaitForResultListener;

class GameResultEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {
        if ($game->getStatus() != Game::GAME_IN_ACTION) {
            return false;
        }

        $repository = $this->doctrine->getRepository(GameQuestion::class);

        $allQuestionsCounter = $repository->CountAllQuestions($game);

        $firstUserCounter = $repository->CountAnswers($game->getFirstUser(), $game);
        $secondUserCounter = $repository->CountAnswers($game->getSecondUser(), $game);

        if ($firstUserCounter != $allQuestionsCounter && $secondUserCounter != $allQuestionsCounter) {

            return false;

        } elseif ($firstUserCounter != $allQuestionsCounter) {

            $event = new WaitForResultListener($this->doctrine, $this->messageDriver);
            $event->fire($game->getSecondUser());

            return false;

        } elseif ($secondUserCounter != $allQuestionsCounter) {

            $event = new WaitForResultListener($this->doctrine, $this->messageDriver);
            $event->fire($game->getFirstUser());

            return false;
        }

        $firstUserAnswers = $repository->CountRightAnswers($game->getFirstUser(), $game);
        $secondUserAnswers = $repository->CountRightAnswers($game->getSecondUser(), $game);

        $firstDateBegin = $repository->findFirstQuestion($game->getFirstUser(), $game)->getDateBegin();
        $firstDateEnd = $repository->findLastQuestion($game->getFirstUser(), $game)->getDateEnd();

        $secondDateBegin = $repository->findFirstQuestion($game->getSecondUser(), $game)->getDateBegin();
        $secondDateEnd = $repository->findLastQuestion($game->getSecondUser(), $game)->getDateEnd();

        $firstTime = $firstDateEnd->getTimestamp() - $firstDateBegin->getTimestamp();
        $secondTime = $secondDateEnd->getTimestamp() - $secondDateBegin->getTimestamp();

        $firstResult = $firstUserAnswers * 1 / $firstTime;
        $secondResult = $secondUserAnswers * 1 / $secondTime;

        $event = new GameResultListener($this->doctrine, $this->messageDriver);
        $event->fire($game->getFirstUser(), $firstUserAnswers, $firstTime, $secondUserAnswers, $secondTime);
        $event->fire($game->getSecondUser(), $secondUserAnswers, $secondTime, $firstUserAnswers, $firstTime);

        $event = new GameEndEvent($this->doctrine, $this->messageDriver);

        if ($firstResult == $secondResult) {

            //ничья

        } elseif ($firstResult < $secondResult) {

            $event->fire($game, $game->getFirstUser());

        } elseif ($firstResult > $secondResult) {

            $event->fire($game, $game->getSecondUser());

        }
    }
}