<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameResultListener;
use AppBundle\Game\Listeners\WaitForResultListener;

class GameResultEvent extends GameAbstractEvent
{
    public function fire(Game $game, User $user = null)
    {
        if ($game->getStatus() != Game::GAME_IN_ACTION) {
            return false;
        }

        $repository = $this->doctrine->getRepository(GameQuestion::class);

        $allFirstUserQuestionsCounter = $repository->CountFirstUserAllQuestions($game);
        $allSecondUserQuestionsCounter = $repository->CountSecondUserAllQuestions($game);

        $firstUserCounter = $repository->CountAnswers($game->getFirstUser(), $game);
        $secondUserCounter = $repository->CountAnswers($game->getSecondUser(), $game);

        if ($firstUserCounter != $allFirstUserQuestionsCounter && $secondUserCounter != $allSecondUserQuestionsCounter) {

            return false;

        } elseif ($firstUserCounter != $allFirstUserQuestionsCounter && $user == $game->getSecondUser()) {

            $event = new WaitForResultListener($this->doctrine, $this->messageDriver);
            $event->fire($game->getSecondUser());

            return false;

        } elseif ($secondUserCounter != $allSecondUserQuestionsCounter && $user == $game->getFirstUser()) {

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

        $firstResult = $firstUserAnswers - $firstTime / 10;
        $secondResult = $secondUserAnswers - $secondTime / 10;

        $event = new GameResultListener($this->doctrine, $this->messageDriver);
        $event->fire($game->getFirstUser(), $firstUserAnswers, $firstTime, $secondUserAnswers, $secondTime);
        $event->fire($game->getSecondUser(), $secondUserAnswers, $secondTime, $firstUserAnswers, $firstTime);

        $event = new GameEndEvent($this->doctrine, $this->messageDriver);

        if ($firstResult == $secondResult) {

            $event->fire($game);

        } elseif ($firstResult > $secondResult) {

            $event->fire($game, $game->getFirstUser());

        } elseif ($firstResult < $secondResult) {

            $event->fire($game, $game->getSecondUser());

        }
    }
}