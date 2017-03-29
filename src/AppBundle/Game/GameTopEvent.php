<?php

namespace AppBundle\Game;


use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\Listeners\GameTopListener;

class GameTopEvent extends GameAbstractEvent
{
    public function fire(User $user, $value = null)
    {
        $message = "";
        $query = $this->doctrine->getManager()->createQuery(
            'SELECT  IDENTITY(g.winner) as winner, count(g.id) as rating
            FROM AppBundle\Entity\Game g
    WHERE g.status = 4
    GROUP BY g.winner
    ORDER BY rating DESC'
        )->setMaxResults(5);

        $rating  = $query->getArrayResult();

        foreach($rating as $rate) {
            $user1 = $this->doctrine->getRepository(User::class)->findOneBy(["id" => $rate["winner"]]);
            $message .= $user1->getFirstName()." ".$user1->getLastName()." vk.com/id".$user1->getImportId()." ".$rate["rating"]."<br>";
        }

        $listener = new GameTopListener($this->doctrine, $this->messageDriver);
        $listener->fire($user, $message);
    }
}