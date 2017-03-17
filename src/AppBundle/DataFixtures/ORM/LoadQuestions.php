<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadQuestions extends AbstractFixture implements OrderedFixtureInterface
{
    const QUESTIONS = [
        1 => 'Путь в какую страну искал Колумб?',
        2 => 'Чем лечил своих пациентов Доктор Айболит?',
        3 => 'Как ученые прозвали теорию происхождения современной Вселенной',
        4 => 'В каком году родился А.С. Пушкин?',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::QUESTIONS as $ACTION => $QUESTION) {
            $question = new Question();

            $question->setQuestion($QUESTION);

            $manager->persist($question);
            $manager->flush();
            $this->setReference('question_'.$ACTION, $question);
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
        return 2;
    }
}