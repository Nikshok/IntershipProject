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
      //  $json_string = '{"type":"message_new","object":{"id":19,"date":1489756944,"out":0,"user_id":87305277,"read_state":0,"title":" ... ","body":"поиск"},"group_id":142630176}';

        $request = json_decode($request->getContent(), true);
        $request_user = $request['object'];

       // var_dump($request);
       // var_dump($request_user);

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByImportIdAndProviderId($request_user['user_id'], User::PROVIDER_VK);

        if (!($user)) {

            $user = new User();

            $user->setFirstName('asdfasf');
            $user->setLastName('dfcz');
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

        new $eventClassName($this->getDoctrine(), $sender, $user, $eventArr['param']);

        $sender->execute();

        return new Response('OK');
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
