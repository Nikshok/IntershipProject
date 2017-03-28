<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;

class GameResultEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {
        if ($game->getStatus() != Game::GAME_IN_ACTION) {
            return false;
        }

        $repository = $this->doctrine->getRepository(GameQuestion::class);

        $firstUserCounter = $repository->CountAnswers($game->getFirstUser(), $game);

        if ($firstUserCounter != 4) {
            return false;
        }

        $secondUserCounter = $repository->CountAnswers($game->getSecondUser(), $game);

        if ($secondUserCounter != 4) {
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

        $firstResult = $firstUserAnswers * $firstTime;
        $secondResult = $secondUserAnswers * $secondTime;

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