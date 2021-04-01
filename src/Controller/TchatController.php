<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TchatController extends AbstractController
{
    /**
     * @Route("/", name="tchat")
     */
    public function index(): Response
    {
        return $this->render('tchat/index.html.twig', [
            
        ]);
    }



     /**
     * @Route("/message/{id_user}/{id_friend}", name="message")
     */
    public function message(): Response
    {
        $message = [
            [
                'id' => 1,
                'message' => 'Salut ca va?'
            ],
            [
                'id' => 2,
                'message' => 'Bien et toi'
            ]
        ];
        return $this->json($message);
        // apelle ajax en jquery
    }
}
