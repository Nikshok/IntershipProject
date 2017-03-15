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
        $json_string = '{"id":87305277,"first_name":"Lindsey","last_name":"Stirling","message":"фываыфва"}';

        $request_user = json_decode($json_string, true);

        $user = new User();

        $user->setFirstName($request_user['first_name']);
        $user->setLastName($request_user['last_name']);
        $user->setImportId($request_user['id']);
        $user->setProviderId(User::PROVIDER_VK);

        $users = $this->getDoctrine()->getRepository(User::class)->findOneByImportIdAndProviderId($user);

        $parser = $this->get('message_parser_service');

        $eventArr = $parser->parseMessage($request_user['message']);

        $event = $this->get($eventArr['']);

        $sender = $this->get('sender_vk_service');
        $sender->sendMessage($user, 'hello');

        if (isset($users)) {

            return $this->render('@App/default/base.html.twig', [
                'user' => $user,
            ]);

        } else {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('@App/default/base.html.twig', [
                'user' => $user,
            ]);
        }

    }

}
