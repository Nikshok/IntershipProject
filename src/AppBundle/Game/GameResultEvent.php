<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;

class GameResultEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {
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

    }
}