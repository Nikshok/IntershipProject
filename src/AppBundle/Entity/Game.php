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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstUserId
     *
     * @param integer $firstUserId
     *
     * @return Game
     */
    public function setFirstUserId($firstUserId)
    {
        $this->firstUserId = $firstUserId;

        return $this;
    }

    /**
     * Get firstUserId
     *
     * @return int
     */
    public function getFirstUserId()
    {
        return $this->firstUserId;
    }

    /**
     * Set secondUserId
     *
     * @param integer $secondUserId
     *
     * @return Game
     */
    public function setSecondUserId($secondUserId)
    {
        $this->secondUserId = $secondUserId;

        return $this;
    }

    /**
     * Get secondUserId
     *
     * @return int
     */
    public function getSecondUserId()
    {
        return $this->secondUserId;
    }

    /**
     * @return int
     */
    public function getWinnerId()
    {
        return $this->winnerId;
    }

    /**
     * @param int $winnerId
     */
    public function setWinnerId(int $winnerId)
    {
        $this->winnerId = $winnerId;
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * @param int $statusId
     */
    public function setStatusId(int $statusId)
    {
        $this->statusId = $statusId;
    }


}