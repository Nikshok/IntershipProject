<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAnswers extends AbstractFixture implements OrderedFixtureInterface
{

    const RIGHT_ANSWERS = [
        1 => 'Индия',
        2 => 'Гоголем-моголем',
        3 => 'Большой взрыв',
        4 => '1799',
    ];

    const FALSE_ANSWERS = [
        1 =>
        [
            1 => 'Япония',
            3 => 'Китай',
            4 => 'Эфиопия'
        ],
        2 =>
        [
            1 => 'Рыбьим жиром',
            3 => 'Касторкой',
            4 => 'Активированным углем '
        ],
        3 =>
        [
            1 => 'Большой катаклизм',
            3 => 'Большой бум',
            4 => 'Большая вспышка'
        ],
        4 =>
        [
            1 => '1803',
            3 => '1793',
            4 => '1748'
        ]
    ];
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        /*$em = $manager->getRepository(Question::class)->findOneBy([
            'id' => 1,
        ]);

        echo $em->getId();*/

        foreach (self::RIGHT_ANSWERS as $NUMBER => $RIGHT_ANSWER) {



            $answer = new Answer();

            $answer->setAnswer($RIGHT_ANSWER);
            $answer->setQuestionId($this->getReference('question_'.$NUMBER));
            $answer->setIsCorrect(true);
            $manager->persist($answer);
            $manager->flush();
        }

        foreach (self::FALSE_ANSWERS as $ID => $FALSE_ANSWER) {
            foreach ($FALSE_ANSWER as $NUMBER => $ANSWER) {
                $answer = new Answer();

                $answer->setAnswer($ANSWER);
                $answer->setQuestionId($this->getReference('question_'.$ID));
                $answer->setIsCorrect(false);
                $manager->persist($answer);
                $manager->flush();
            }
        }
    }
}