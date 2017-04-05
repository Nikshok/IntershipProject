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
        /*$json_string = '{"update_id":370249058,
        "message":{"message_id":68,"from":{"id":356777695,"first_name":"Konstantin","last_name":"Plotkin","username":"kudrik"},
        "chat":{"id":356777695,"first_name":"Konstantin","last_name":"Plotkin","username":"kudrik","type":"private"},
        "date":1491317977,"text":"топ"}}';


        $request = json_decode($json_string, true);
        $request_user = $request["message"]["chat"];

        var_dump($request_user['id']);*/

        if (!$request = json_decode($request->getContent(), true)) {
            return new Response('OK');
        }

        if (!isset($request['message'])) {
            return new Response('OK');
        }

        if (!isset($request["message"]["chat"]) || $request["message"]["chat"] == null) {
            return new Response('OK');
        }

        $request_user = $request["message"]["chat"];

        if (!isset($request_user['id']) || !isset($request_user['username'])) {
            return new Response('OK');
        }

        if ($request_user['id'] == null || $request_user['username'] == null) {
            return new Response('OK');
        }

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByImportIdAndProviderId($request_user['id'], User::PROVIDER_TG);

        if (!($user)) {
            $user = new User();
            $user->setFirstName($request_user['first_name']);
            $user->setLastName($request_user['last_name']);
            $user->setImportId($request_user['id']);
            $user->setProviderId(User::PROVIDER_TG);
            $user->setUsername($request_user['username']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        $parser = $this->get('message_parser_service');
        $eventArr = $parser->parseMessage($request['message']['text']);

        $sender = $this->get('message_driver_service');

        $eventClassName = '\AppBundle\Game\\' . $eventArr['event_name'];

        $event = new $eventClassName($this->getDoctrine(), $sender);
        $event->fire($user, $eventArr['param']);

        $sender->execute();

        return new Response('OK');
    }

}
