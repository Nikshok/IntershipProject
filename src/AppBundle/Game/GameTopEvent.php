<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameTopListener;

class GameTopEvent extends GameAbstractEvent
{
    public function fire(User $user, $value = null)
    {
        $users = [];
        $rating = $this->doctrine->getRepository(Game::class)->findRatingUsers(5);

        foreach($rating as $num => $rate) {

            array_push($users, array($this->doctrine->getRepository(User::class)->findOneBy(["id" => $rate["winner"]]), $rate["rating"]));

        }

        $listener = new GameTopListener($this->doctrine, $this->messageDriver);
        $listener->fire($user, $users);
    }
}