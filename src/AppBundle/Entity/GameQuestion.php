<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameQuestion
 *
 * @ORM\Table(name="game_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameQuestionRepository")
 */
class GameQuestion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="id")
     * @ORM\JoinColumn(name="game", referencedColumnName="id", nullable=false)
     */
    private $game;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="id")
     * @ORM\JoinColumn(name="question", referencedColumnName="id", nullable=false)
     */
    private $question;

    /**
     * @var int
     *
     * @ORM\Column(name="answer_checker", type="integer", nullable=true)
     */
    private $answerChecker;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_begin", type="datetime", nullable=true)
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @var int
     *
     * @ORM\Column(name="answer_param", type="integer", nullable=true)
     */
    private $answerParam;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set answerChecker
     *
     * @param integer $answerChecker
     *
     * @return GameQuestion
     */
    public function setAnswerChecker($answerChecker)
    {
        $this->answerChecker = $answerChecker;

        return $this;
    }

    /**
     * Get answerChecker
     *
     * @return integer
     */
    public function getAnswerChecker()
    {
        return $this->answerChecker;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return GameQuestion
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateBegin
     *
     * @param \DateTime $dateBegin
     *
     * @return GameQuestion
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    /**
     * Get dateBegin
     *
     * @return \DateTime
     */
    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return GameQuestion
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set answerParam
     *
     * @param integer $answerParam
     *
     * @return GameQuestion
     */
    public function setAnswerParam($answerParam)
    {
        $this->answerParam = $answerParam;

        return $this;
    }

    /**
     * Get answerParam
     *
     * @return integer
     */
    public function getAnswerParam()
    {
        return $this->answerParam;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return GameQuestion
     */
    public function setGame(\AppBundle\Entity\Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return GameQuestion
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return GameQuestion
     */
    public function setQuestion(\AppBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
