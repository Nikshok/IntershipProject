<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGameActions implements FixtureInterface
{
    const ACTIONS = [
        '1' => 'поиск',
        '2' => 'отмена',
        '3' => 'готов',
        '4' => 'сдаться',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PHRASES as $ACTION => $PHRASE) {
            $phrase = new Phrase();
            $phrase->setActionId($ACTION);
            $phrase->setPhrase($PHRASE);

            $manager->persist($phrase);
            $manager->flush();
        }
    }
}