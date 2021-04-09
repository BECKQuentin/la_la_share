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
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('member/view.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/member/update", name="member_update")
     * @IsGranted("ROLE_USER")
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
    public function allMembers(UserRepository $userRepository): Response
    {
        $members = $userRepository->findAllMember($this->getUser());
        
        return $this->render('member/allMembers.html.twig', [
            'members' => $members            
        ]);     
    }

    /**
    * @Route("/ask-friend/{id}", name="ask_friend")
    */
    public function askFriend(User $member, EmailService $emailService): Response
    {
        $user = $this->getUser();

        $friend = new FriendsRequest();
        $friend->setSender($user);
        $friend->setReceiver($member);
        $friend->setAccepted(0);   

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
        $em->persist($friend);
        $em->flush();
        
        $this->addFlash('success', "Demande envoyée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }

    /**
    * @Route("/add-friend/{id}", name="add_friend")
    */
    public function addFriend(
        FriendsRequestRepository $friendsRequestRepository,
        User $member,
        EmailService $emailService
        ): Response
    {
        $user = $this->getUser();
        $friend = $friendsRequestRepository->findOneBy([$user, $member], []);

        //changer boolean de la requete friend        
        $friend->setSender($user);
        $friend->setReceiver($member);
        $friend->setAccepted(1);

        //email a envoyer 'vous etes amis' && 'demande acceptée'
        $emailService->send([                
            'to' => '$user->getEmail', //if empty => adminEmail
            'subject' => 'Vous avez une nouvelle demande d\'ami',
            'template' => 'email/friend_accepted.html.twig',
            'context' => [
                'user' => $user,
                'member' => $member
            ],
        ]);
        
        $this->addFlash('success', "Demande acceptée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }

    /**
    * @Route("/refuse-friend/{id}", name="refuse_friend")
    */
    public function refuseFriend(User $member, FriendsRequestRepository $friendsRequestRepository, EmailService $emailService): Response
    {
        $user = $this->getUser();
        $friend = $friendsRequestRepository->findOneBy([$user, $member], []);

        //changer boolean de la requete friend        
        $friend->setSender($user);
        $friend->setReceiver($member);
        $friend->setAccepted(0);   
        
        $this->addFlash('warning', "Demande refusée !");
        return $this->redirectToRoute('all_members', [
        ]);
    }
    
}