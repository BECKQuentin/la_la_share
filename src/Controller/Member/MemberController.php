<?php

namespace App\Controller\Member;

use App\Entity\FriendsRequest;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\FriendsRequestRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MemberController extends AbstractController
{
    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
    * @Route("/", name="member") 
    * @IsGranted("ROLE_USER", message="Seules les membres peuvent faire ça")
    */
    public function index(FriendsRequestRepository $friendsRequestRepository): Response
    {
        $user = $this->getUser();

        $requests = $friendsRequestRepository->findReceivedFriendsRequestsPending($user);

        return $this->render('member/view.html.twig', [
            'user' => $user,
            'requests' => $requests
        ]);
    }

    /**
    * @Route("/member/update", name="member_update")
    * @IsGranted("ROLE_USER", message="Seules les membres peuvent faire ça")
    */
    public function memberUpdate(Request $request)
    {        
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->remove('email')->remove('plainPassword')->remove('agreeTerms')->remove('submit');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $fileName = $this->uploadService->uploadImage($image, $user);
                $user->setImage($fileName);
            }
            
            //dd($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Les modifications ont bien été sauvegardées !");
            return $this->redirectToRoute('member_update', ['id' => $user->getId()]);
        }

        return $this->render('member/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
    * @Route("/all-members", name="all_members")
    */
    public function allMembers(Request $request, UserRepository $userRepository): Response
    {        
        return $this->render('member/allMembers.html.twig', [
            'members' => $userRepository->userSearch($this->getUser(), $request->request->all())       
        ]);     
    }

    /**
    * @Route("/ask-friend/{id}", name="ask_friend")
    */
    public function askFriend(
        User $member,
        EmailService $emailService): Response
    {
        $user = $this->getUser();

        $friendRequest = new FriendsRequest();
        $friendRequest->setSender($user);
        $friendRequest->setReceiver($member);
        $friendRequest->setAccepted(0);   

        //email a envoyer 'demande recue' && 'demande envoyée'
        $emailService->send([
            'to' => $member->getEmail(), //if empty => adminEmail
            'subject' => 'Vous avez une nouvelle demande d\'ami',
            'template' => 'email/send_friend.html.twig',
            'context' => [
                'user' => $user,
                'member' => $member
            ],
        ]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($friendRequest);
        $em->flush();
        
        $this->addFlash('success', "Demande envoyée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }

    /**
    * @Route("/accept-friend-request/{id}", name="accept_friend_request")
    */
    public function acceptFriendRequest(
        FriendsRequestRepository $friendsRequestRepository,
        User $sender,
        EmailService $emailService
        ): Response
    {
        $receiver = $this->getUser();
        
        $friendRequest = $friendsRequestRepository->findOneBy([
            'sender' => $sender,
            'receiver' => $receiver
        ]);
        
        //changer boolean de la requete friend
        $friendRequest->setAccepted(true);
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        //email a envoyer 'vous etes amis' && 'demande acceptée'
        $emailService->send([                
            'to' => $sender->getEmail(), //if empty => adminEmail
            'subject' => 'Vous avez une nouvel ami',
            'template' => 'email/friend_accepted.html.twig',
            'context' => [
                'sender' => $sender,
                'receiver' => $receiver
            ],
        ]);
        
        $this->addFlash('success', "Demande acceptée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }

    /**
    * @Route("/refuse-friend-request/{id}", name="refuse_friend_request")
    */
    public function refuseFriendRequest(
        User $sender,
        FriendsRequestRepository $friendsRequestRepository
        ): Response
    {
        $receiver = $this->getUser();

        $friendRequest = $friendsRequestRepository->findOneBy([
            'sender' => $sender,
            'receiver' => $receiver
        ], []);
        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($friendRequest);        
        $em->flush();        
        $this->addFlash('danger', "Demande refusée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }

    /**
    * @Route("/delete-friend/{id}", name="delete_friend")
    */
    public function deleteFriend(
        User $sender,
        FriendsRequestRepository $friendsRequestRepository
        ): Response
    {
        $receiver = $this->getUser();

        $friendsRequestRepository->deleteFriendAccepted($receiver, $sender);       
        
        $this->addFlash('danger', "Vous n'êtes plus ami avec ".$sender->getPseudo()." !");
        return $this->redirectToRoute('all_members', [
        ]);
    }
    
    
}