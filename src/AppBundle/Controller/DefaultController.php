<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/vk/controller", name="homepage")
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/info")
     */
    public function infoAction(Request $request)
    {
        $json_string = '{"id":210700286,"first_name":"Lindsey","last_name":"Stirling"}';

        $request_user = json_decode($json_string, true);

        $user = new User();

        $user->setFirstName($request_user['first_name']);
        $user->setLastName($request_user['last_name']);
        $user->setImportId($request_user['id']);
        $user->setProviderId(User::PROVIDER_VK);

        $users = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'importId' => $user->getImportId(), 'providerId' => $user->getProviderId()
        ]);

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

    /**
     * @Route("/sendMessage")
     * @param Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $sender = $this->get('sender_service');
        $sender->sendMessage(87305277, 'hello');

        $response = new Response();

        $response->setStatusCode(Response::HTTP_OK);

        return $response;

    }
}
