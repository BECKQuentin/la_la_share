<?php

namespace App\Controller\Member;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
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
        $members = $userRepository->findAllMember();
        
        return $this->render('member/allMembers.html.twig', [
            'members' => $members
        ]);     
    }
    
}