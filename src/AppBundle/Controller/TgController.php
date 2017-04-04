<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/tg")
 */
class TgController extends Controller
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

        if (!isset($request_user['id']) || !isset($request_user['body'])) {
            return new Response('OK');
        }

        if ($request_user['id'] == null || $request_user['body'] == null) {
            return new Response('OK');
        }

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByImportIdAndProviderId($request_user['id'], User::PROVIDER_TG);

        if (!($user)) {

            $user = new User();

            $tgService = $this->get('tg_service');
            $userInfo = $tgService->getUserInfo($request_user['user_id']);

            $user->setFirstName($userInfo['first_name']);
            $user->setLastName($userInfo['last_name']);
            $user->setAvatar($userInfo['avatar']);
            $user->setImportId($request_user['id']);
            $user->setProviderId(User::PROVIDER_TG);

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

}
