<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\AbstractFixture;
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
        foreach (self::QUESTIONS_ANSWERS as $ACTION => $VARIANT) {
            foreach ($VARIANT as $NUMBER => $QUESTION) {
                if ($NUMBER == 0) {

                    $question = new Question();
                    $question->setQuestion($QUESTION);
                    $manager->persist($question);
                    $manager->flush();
                    $this->setReference('question_' . $ACTION, $question);

                } else {

                    $answer = new Answer();
                    $answer->setAnswer($QUESTION);
                    $answer->setQuestionId($this->getReference('question_' . $ACTION));
                    if ($NUMBER == 1) {
                        $answer->setIsCorrect(true);
                    } else {
                        $answer->setIsCorrect(false);
                    }
                    $manager->persist($answer);
                    $manager->flush();

                }
            }
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