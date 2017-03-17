<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



/**
 * @Route("/vk", name="homepage")
 */
class VKController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $json_string = '{"id":87305277,"first_name":"Lindsey","last_name":"Stirling","message":"поиск"}';

        $request_user = json_decode($json_string, true);

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByImportIdAndProviderId($request_user['id'], User::PROVIDER_VK);

        if (!($user)) {

            $user = new User();

            $user->setFirstName($request_user['first_name']);
            $user->setLastName($request_user['last_name']);
            $user->setImportId($request_user['id']);
            $user->setProviderId(User::PROVIDER_VK);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        }

        $parser = $this->get('message_parser_service');

        $eventArr = $parser->parseMessage($request_user['message']);    //return ['event_name', 'param']

        $sender = $this->get('message_driver_service');

        $eventClassName = '\AppBundle\Game\\' . $eventArr['event_name'];

        new $eventClassName($this->getDoctrine(), $sender, $user);

        $sender->execute();

        return new Response(Response::HTTP_OK);
    }

    /**
     * @Route("/test")
     */
    public function testAction() {
        $sender = $this->get('message_driver_service');
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->find(1);

        $event = new GameSearchEvent($this->getDoctrine(), $sender, $user);

        $sender->execute();
    }

}
