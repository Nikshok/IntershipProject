<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Game;
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
<<<<<<< HEAD
=======
        $json_string = '{"id":418599422,"first_name":"Lindsey","last_name":"Stirling","message":"фываыфва"}';
>>>>>>> 3a16ee4bd4f103b2c75f3ebb509286395d36021b

        $game = $this->getDoctrine()->getRepository(Game::class)->findAll();

        var_dump($game);
        $request = json_decode($request->getContent(), true);
        $request_user = $request['object'];

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

        new $eventClassName($this->getDoctrine(), $sender, $user, $eventArr['param']);

        $sender->execute();


        $game = $this->getDoctrine()->getRepository(Game::class)->findAll();

        var_dump($game);



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

    /**
     * @Route("/findGame")
     */
    public function findGame()
    {
        $em = $this->getDoctrine()->getManager();
        $findUser = $em->getRepository(User::class)->findOneBy([
            'id' => 1
        ]);
        $findGame = $this->get('find_game_service')->searchGame($findUser);
        $response = new Response();

        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
