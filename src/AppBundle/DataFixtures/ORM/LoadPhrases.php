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
        '4' => 'Игра началась!',
        '5' => 'В течении 5 минут подтвердите что готовы играть, отправив команду - Готов',
        '6' => 'Ваш соперник сдался.',
        '7' => 'Вы победили!',
        '8' => 'Вы проиграли.',
        '9' => 'Ничья.',
        '10' => 'Игра отменена.',
        '11' => 'Топ пользователей по победам:'
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