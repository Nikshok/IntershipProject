<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrentGameQuestions
 *
 * @ORM\Table(name="current_game_questions")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrentGameQuestionsRepository")
 */
class CurrentGameQuestions
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
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="id")
     * @ORM\JoinColumn(name="question", referencedColumnName="id", nullable=false)
     */
    private $question;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="id")
     * @ORM\JoinColumn(name="game", referencedColumnName="id", nullable=true)
     */
    private $answer;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBegin", type="datetime", nullable=true)
     */
    private $dateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime", nullable=true)
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set game
     *
     * @param integer $game
     *
     * @return CurrentGameQuestions
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return int
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set question
     *
     * @param integer $question
     *
     * @return CurrentGameQuestions
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return int
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return CurrentGameQuestions
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set answer
     *
     * @param integer $answer
     *
     * @return CurrentGameQuestions
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return int
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CurrentGameQuestions
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
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
     * @return CurrentGameQuestions
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
     * @return CurrentGameQuestions
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
     * @return CurrentGameQuestions
     */
    public function setAnswerParam($answerParam)
    {
        $this->answerParam = $answerParam;

        return $this;
    }

    /**
     * Get answerParam
     *
     * @return int
     */
    public function getAnswerParam()
    {
        return $this->answerParam;
    }
}
