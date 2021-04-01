<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\WebAuthenticator;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request, 
        UserPasswordEncoderInterface $passwordEncoder, 
        GuardAuthenticatorHandler $guardHandler, 
        WebAuthenticator $authenticator
        ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Envoi mail
            /*$emailService->send([
                'to' => '$user->getEmail', //if empty => adminEmail
                'subject' => 'Validez votre inscription',
                'template' => 'email/security/verify_email.html.twig',
                'context' => [
                    'user' => $user
                ],
            ]);*/

            $this->addFlash("success", "Merci de vérifier votre compte en cliquant sur le lien que nous vous avons envoyé dans le mail.");
            return $this->redirectToRoute('app_login');

            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main' // firewall name in security.yaml
            // );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("verify-email/{token}", name="verify_email")
     */

     public function verifyEmail(
         string $token,
         UserRepository $userRepository,
         GuardAuthenticatorHandler $guardHandler,
         WebAuthenticator $authenticator,
         Request $request
     )
     {
        
     }
}
