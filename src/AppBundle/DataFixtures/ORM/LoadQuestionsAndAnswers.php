<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadQuestionsAndAnswers extends AbstractFixture implements OrderedFixtureInterface
{
    const QUESTIONS_ANSWERS = array(
        array(
            //нулевая запись в массиве всегда будет вопрос
            'Какой вопрос вы бы задали на вопрос?',
            //далее первая запись всегда правильный ответ
            'Правильный ответ!',
            //остальные не правильный ответы
            'Нерпавильный ответ 1',
            'Неправильный ответ 2',
            'Неправильный ответ 3'),
        array(
            'Путь в какую страну искал Колумб?',
            'Индия',
            'Япония',
            'Китай',
            'Эфиопия'
        ),
        array(
            'Чем лечил своих пациентов Доктор Айболит?',
            'Гоголем-моголем',
            'Рыбьим жиром',
            'Касторкой',
            'Активированным углем',
        ),
        array(
            'Как ученые прозвали теорию происхождения современной Вселенной',
            'Большой взрыв',
            'Большой катаклизм',
            'Большой бум',
            'Большая вспышка'),
        array(
            'В каком году родился А.С. Пушкин?',
            '1799',
            '1803',
            '1793',
            '1748'
        ),
    );


    public function load(ObjectManager $manager)
    {
        foreach (self::QUESTIONS_ANSWERS as $ACTION => $QUESTION) {

           //TODO
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