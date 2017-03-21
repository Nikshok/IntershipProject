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
     * @param integer $statusId
     *
     * @return Game
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return integer
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set firstUserId
     *
     * @param \AppBundle\Entity\User $firstUserId
     *
     * @return Game
     */
<<<<<<< HEAD
    public function setFirstUser(int $firstUserId)
=======
    public function setFirstUserId(\AppBundle\Entity\User $firstUserId)
>>>>>>> 06be8f91fcd680269878daa26b3fddc20f7cf783
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
     * @param \AppBundle\Entity\User $secondUserId
     *
     * @return Game
     */
<<<<<<< HEAD
    public function setSecondUser(int $secondUserId)
=======
    public function setSecondUserId(\AppBundle\Entity\User $secondUserId = null)
>>>>>>> 06be8f91fcd680269878daa26b3fddc20f7cf783
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
<<<<<<< HEAD
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

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
=======
     * Set winnerId
     *
     * @param \AppBundle\Entity\User $winnerId
     *
     * @return Game
     */
    public function setWinnerId(\AppBundle\Entity\User $winnerId = null)
    {
        $this->winnerId = $winnerId;

        return $this;
    }

    /**
     * Get winnerId
     *
     * @return \AppBundle\Entity\User
     */
    public function getWinnerId()
    {
        return $this->winnerId;
>>>>>>> 06be8f91fcd680269878daa26b3fddc20f7cf783
    }
}
