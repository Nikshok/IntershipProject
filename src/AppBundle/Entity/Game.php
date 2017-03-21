<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="first_user", referencedColumnName="id", nullable=false)
     */
    private $firstUser;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="second_user", referencedColumnName="id", nullable=true)
     */
    private $secondUser;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="winner", referencedColumnName="id", nullable=true)
     */
    private $winner;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

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
     * Set statusId
     *
     * @param integer $status
     *
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set firstUser
     *
     * @param $firstUserId
     *
     * @return Game
     */
    public function setFirstUser(int $firstUserId)
    {
        $this->firstUser = $firstUserId;

        return $this;
    }

    /**
     * Get firstUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getFirstUser()
    {
        return $this->firstUser;
    }

    /**
     * Set secondUser
     *
     * @param $secondUserId
     *
     * @return Game
     */
    public function setSecondUser(int $secondUserId)
    {
        $this->secondUser = $secondUserId;

        return $this;
    }

    /**
     * Get secondUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getSecondUser()
    {
        return $this->secondUser;
    }

    /**
     * @return int
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param int $winnerId
     */
    public function setWinner(int $winnerId)
    {
        $this->winner = $winnerId;
    }
}
