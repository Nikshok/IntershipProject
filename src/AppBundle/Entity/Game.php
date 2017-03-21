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
     * Set status
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
     * Get status
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
     * @param User $firstUser
     *
     * @return Game
     */
    public function setFirstUserId(User $firstUser)
    {
        $this->firstUser = $firstUser;

        return $this;
    }

    /**
     * Get firstUserId
     *
     * @return User
     */
    public function getFirstUser()
    {
        return $this->firstUser;
    }

    /**
     * Set secondUser
     *
     * @param User $secondUser
     *
     * @return Game
     */
    public function setSecondUserId(User $secondUser)
    {
        $this->secondUser = $secondUser;

        return $this;
    }

    /**
     * Get secondUser
     *
     * @return User
     */
    public function getSecondUser()
    {
        return $this->secondUser;
    }

    /**
     * Set winner
     *
     * @param User $winner
     *
     * @return Game
     */
    public function setWinner(User $winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return User
     */
    public function getWinner()
    {
        return $this->winner;
    }
}
