<?php

namespace AppBundle\Game;

use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

abstract class GameAbstractEvent
{
    protected $doctrine;
    protected $messageDriver;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;

    }

}