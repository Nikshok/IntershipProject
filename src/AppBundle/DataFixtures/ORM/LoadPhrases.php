<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Phrase;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPhrases implements FixtureInterface
{
    const PHRASES = [
        '1' => 'Идет поиск соперника...',
        '2' => 'Поиск отменен',
        '3' => 'Соперник найден - [user]!',
        '5' => 'Игра началась!',
        '6' => 'В течении 5 минут подтвердите что готовы играть, отправив команду - Готов',
        '7' => 'Ваш соперник сдался.',
        '8' => 'Вы победили!',
        '9' => 'Вы проиграли.',
        '10' => 'Ничья.',
        '11' => 'Игра отменена.',
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