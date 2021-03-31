<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicsController extends AbstractController
{
    /**
     * @Route("/musics", name="musics")
     */
    public function index(): Response
    {
        return $this->render('musics/musics.html.twig', [
            
        ]);
    }
}
