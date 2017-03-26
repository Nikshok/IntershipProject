<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Game\GameResultEvent;
use AppBundle\Game\GetResultEvent;
use AppBundle\Game\SelecetQuestionsEvent;
use AppBundle\Game\SendQuestionEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * @Route("/vk", name="homepage")
 */
class VkController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        if (!$request = json_decode($request->getContent(), true)) {
            return new Response('OK');
        }

        if (!isset($request['object'])) {
            return new Response('OK');
        }

        $request_user = $request['object'];

        if (!isset($request_user['user_id']) || !isset($request_user['body'])) {
            return new Response('OK');
        }

        if ($request_user['user_id'] == null || $request_user['body'] == null) {
            return new Response('OK');
        }

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByImportIdAndProviderId($request_user['user_id'], User::PROVIDER_VK);

        if (!($user)) {

            $user = new User();

            $vkService = $this->get('vk_service');
            $userInfo = $vkService->getUserInfo($request_user['user_id']);

            $user->setFirstName($userInfo['first_name']);
            $user->setLastName($userInfo['last_name']);
            $user->setAvatar($userInfo['avatar']);
            $user->setImportId($request_user['user_id']);
            $user->setProviderId(User::PROVIDER_VK);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        $parser = $this->get('message_parser_service');

        $eventArr = $parser->parseMessage($request_user['body']);    //return ['event_name', 'param']

        $sender = $this->get('message_driver_service');

        $eventClassName = '\AppBundle\Game\\' . $eventArr['event_name'];

        $event = new $eventClassName($this->getDoctrine(), $sender);
        $event->fire($user, $eventArr['param']);

        $sender->execute();

        return new Response('OK');
    }

    /**
     * @Route("/test")
     * @param Request $request
     * @return Response
     */
    public function testAction(Request $request)
    {
//        $userRepository = $this->getDoctrine()->getRepository(User::class);
//        $user = $userRepository->find(24);
//
        $gameRepository = $this->getDoctrine()->getRepository(Game::class);
        $game = $gameRepository->find(10);


        $sender = $this->get('message_driver_service');

        $event = new GameResultEvent($this->getDoctrine(), $sender);

        if (!$event->fire($game)) {

            return new Response('OK');
        }
//
//        $sender->execute();
//
//        return new Response('OK');
    }


}
