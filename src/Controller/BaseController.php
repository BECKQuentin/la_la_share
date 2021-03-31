<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    ////////////////// HEADER ///////////////////////////
    public function header(string $routeName)
    {        
        return $this->render('base/_header.html.twig', [            
            'route_name' => $routeName,
        ]);     
    }

    ////////////////// MUSICS ///////////////////////////
    public function musics(string $routeName)
    {        
        return $this->render('base/musics.html.twig', [            
            'route_name' => $routeName,
        ]);     
    }

    ////////////////// FRIENDS ///////////////////////////
    public function friends(string $routeName)
    {        
        return $this->render('base/friends.html.twig', [            
            'route_name' => $routeName,
        ]);     
    }

    //////////////////// HOME //////////////////////////
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('base/home.html.twig', [
            
        ]);
    }
}
