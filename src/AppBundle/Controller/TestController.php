<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Entity\GameQuestion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/test", name="homepage")
 */
class TestController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/game")
     */
    public function gameAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($this->getDoctrine()->getRepository(GameQuestion::class)->findAll() as $row) {
            $em->remove($row);
        }

        $em->flush();

        foreach ($this->getDoctrine()->getRepository(Game::class)->findAll() as $game) {
            $em->remove($game);
        }

        $em->flush();

        $userRepository = $this->getDoctrine()->getRepository(User::class);

        //select fake user 1
        $user1 = $userRepository->findOneById(3);

        //select fake user 2
        $user2 = $userRepository->findOneById(2);

        $sender = $this->get('message_driver_service');

        //в холостую
        $event = new \AppBundle\Game\GameAnswerEvent($this->getDoctrine(), $sender);
        $event->fire($user1,1);

        $event = new \AppBundle\Game\GameCapitulateEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        $event = new \AppBundle\Game\GameStartEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        $event = new \AppBundle\Game\GameCancelEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру два раза
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый отменяет игру
        $event = new \AppBundle\Game\GameCancelEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //второй ищет игру два раза
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый ищет игру второй раз
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй отменяет игру
        $event = new \AppBundle\Game\GameCancelEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый отменяет
        $event = new \AppBundle\Game\GameCancelEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        $sender->execute();

        return new Response('__');

        //первый соглашается
        $event = new \AppBundle\Game\GameStartEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый сдается
        $event = new \AppBundle\Game\GameCapitulateEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый соглашается
        $event = new \AppBundle\Game\GameStartEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй сдается
        $event = new \AppBundle\Game\GameCapitulateEvent($this->getDoctrine(), $sender);
        $event->fire($user2);




    }

    /**
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/game2")
     */
    public function game2Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($this->getDoctrine()->getRepository(GameQuestion::class)->findAll() as $row) {
            $em->remove($row);
        }

        $em->flush();

        foreach ($this->getDoctrine()->getRepository(Game::class)->findAll() as $game) {
            $em->remove($game);
        }

        $em->flush();

        $userRepository = $this->getDoctrine()->getRepository(User::class);

        //select fake user 1
        $user1 = $userRepository->findOneById(1);

        //select fake user 2
        $user2 = $userRepository->findOneById(2);

        $sender = $this->get('message_driver_service');

        //первый ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        //второй ищет игру
        $event = new \AppBundle\Game\GameSearchEvent($this->getDoctrine(), $sender);
        $event->fire($user2);

        //первый соглашается
        $event = new \AppBundle\Game\GameStartEvent($this->getDoctrine(), $sender);
        $event->fire($user1);

        $sender->execute();

        //второй отвечает один раз
        $event = new \AppBundle\Game\GameAnswerEvent($this->getDoctrine(), $sender);
        $event->fire($user2,1);

        $sender->execute();


        //первый отвечает на все вопросы
        for ($i=0; $i<25; $i++) {

            $event = new \AppBundle\Game\GameAnswerEvent($this->getDoctrine(), $sender);
            $event->fire($user1,1);
            $sender->execute();
        }

        //второй отвечает на все вопросы
        for ($i=0; $i<25; $i++) {

            $event = new \AppBundle\Game\GameAnswerEvent($this->getDoctrine(), $sender);
            $event->fire($user2,1);
            $sender->execute();
        }


        return new Response('__');

    }
}