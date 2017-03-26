<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;

class GameResultEvent extends GameAbstractEvent
{
    public function fire(Game $game)
    {
        $repository = $this->doctrine->getRepository(GameQuestion::class);

        $firstUserCounter = $repository->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker IS NOT NULL')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $game->getFirstUser(), 'game' => $game])
            ->getQuery()
            ->getSingleScalarResult();

        if ($firstUserCounter != 4) {
            return false;
        }

        $secondUserCounter = $repository->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker IS NOT NULL')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $game->getSecondUser(), 'game' => $game])
            ->getQuery()
            ->getSingleScalarResult();

        if ($secondUserCounter != 4) {
            return false;
        }

        $firstUserAnswers = $repository->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker = 1')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $game->getFirstUser(), 'game' => $game])
            ->getQuery()
            ->getSingleScalarResult();

        $secondUserAnswers = $repository->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker = 1')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $game->getSecondUser(), 'game' => $game])
            ->getQuery()
            ->getSingleScalarResult();


    }
}