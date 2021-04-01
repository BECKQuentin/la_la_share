<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MusicsController extends AbstractController
{
    /**
     * @Route("/musics", name="musics")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('musics/musics.html.twig', [
            
        ]);
    }
}
