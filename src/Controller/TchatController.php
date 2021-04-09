<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\FriendsRequestRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TchatController extends AbstractController
{
    /**
     * @Route("/", name="tchat")
     */
    public function index(UserRepository $userRepository, FriendsRequestRepository $friendsRequestRepository): Response
    {     
        $user = $this->getUser();
        $friends = $friendsRequestRepository->findMyFriends($user);
        
        return $this->render('tchat/index.html.twig', [
           'friends' => $friends,
        ]);
    }  


     /**
     * @Route("/message/{id}", name="message")
     */
    public function message(User $friend, MessageRepository $messageRepository, UserRepository $userRepository): Response
    {          
        $user = $this->getUser();
        
        $messages = $messageRepository->findConversationBetween($user, $friend);          
        $messagesJson = [];
        foreach ($messages as $message) {
            $messagesJson[] = [
                'id' => $message->getId(),
                'message' => $message->getContent(),
                'send_at' => $message->getSendAt(),
                'send' => $message->getSenderId() === $user->getId()
            ];
        }       
    
        return $this->json($messagesJson);
        // apelle ajax en jquery
    }

    /**
    * @Route("/send-message/{id}", name="send_message")
    */
    public function sendTo(User $friend, MessageRepository $messageRepository,Request $request , UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $inputMessage = $request->request->get('message');
       
        $message = (new Message())
        ->setContent($inputMessage)
        ->setSenderId($user->getId())
        // ->setSenderId($this->getUser()->getId())
        ->setReceiverId($friend->getId());        
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return new Response();     
    }
    
}
