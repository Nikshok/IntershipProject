<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Game;
use AppBundle\Entity\GameQuestion;
use AppBundle\Entity\User;

/**
 * GameQuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GameQuestionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param User $user
     * @param Game $game
     * @return mixed
     */
    public function findNextQuestionForSending(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker IS NULL')
            ->andWhere('gq.status IS NULL')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $query;
    }

    /**
     * @param User $user
     * @param Game $game
     * @return mixed
     */
    public function findCurrentQuestion(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker IS NULL')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $query;
    }

    public function CountFirstUserAllQuestions(Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->Where('gq.game = :game')
            ->andWhere('gq.game = :game')
            ->setParameters(['game' => $game, 'user' => $game->getFirstUser()])
            ->orderBy('gq.id')
            ->getQuery()
            ->getSingleScalarResult();

        return $query;
    }

    public function CountSecondUserAllQuestions(Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->Where('gq.game = :game')
            ->andWhere('gq.game = :game')
            ->setParameters(['game' => $game, 'user' => $game->getSecondUser()])
            ->orderBy('gq.id')
            ->getQuery()
            ->getSingleScalarResult();

        return $query;
    }


    public function CountAnswers(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker IS NOT NULL')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id')
            ->getQuery()
            ->getSingleScalarResult();

        return $query;
    }

    public function CountRightAnswers(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->select('count(gq.id)')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->andWhere('gq.answerChecker = 1')
            ->andWhere('gq.status = 1')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id')
            ->getQuery()
            ->getSingleScalarResult();

        return $query;
    }

    public function findFirstQuestion(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id', 'ASC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $query;
    }

    public function findLastQuestion(User $user, Game $game)
    {
        $query = $this->createQueryBuilder('gq')
            ->where('gq.user = :user')
            ->andWhere('gq.game = :game')
            ->setParameters(['user' => $user, 'game' => $game])
            ->orderBy('gq.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        return $query;
    }

}
