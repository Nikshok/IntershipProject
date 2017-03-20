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
     * @ORM\JoinColumn(name="first_user_id", referencedColumnName="id", nullable=false)
     */
    private $firstUserId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="second_user_id", referencedColumnName="id", nullable=true)
     */
    private $secondUserId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="User", inversedBy="id")
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id", nullable=true)
     */
    private $winnerId;

    /**
     * @var int
     *
     * @ORM\Column(name="status_id", type="integer", nullable=false)
     */
    private $statusId;

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
    public function setFirstUserId(\AppBundle\Entity\User $firstUserId)
    {
        $this->firstUserId = $firstUserId;

        return $this;
    }

    /**
     * Get firstUserId
     *
     * @return \AppBundle\Entity\User
     */
    public function getFirstUserId()
    {
        return $this->firstUserId;
    }

    /**
     * Set secondUserId
     *
     * @param \AppBundle\Entity\User $secondUserId
     *
     * @return Game
     */
    public function setSecondUserId(\AppBundle\Entity\User $secondUserId = null)
    {
        $this->secondUserId = $secondUserId;

        return $this;
    }

    /**
     * Get secondUserId
     *
     * @return \AppBundle\Entity\User
     */
    public function getSecondUserId()
    {
        return $this->secondUserId;
    }

    /**
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
    }
}
