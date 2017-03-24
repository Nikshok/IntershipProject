<?php

namespace AppBundle\Game\Listeners;

use AppBundle\Services;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GameAbstractListener
{

    protected $doctrine;
    protected $messageDriver;

    public function __construct(Registry $doctrine, Services\MessageDriver $messageDriver)
    {
        $this->doctrine = $doctrine;
        $this->messageDriver = $messageDriver;

    }

}