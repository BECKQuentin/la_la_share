<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FriendsRequestRepository;
use App\Repository\MusicsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function musics(string $routeName, MusicsRepository $musicsRepository)
    {    
        $muscis = $musicsRepository->findAll();    
        return $this->render('base/_musics.html.twig', [            
            'route_name' => $routeName,
            'musics' => $muscis            
        ]);     
    }

    ////////////////// FRIENDS ///////////////////////////
    public function friends(string $routeName, UserRepository $userRepository, FriendsRequestRepository $friendsRequestRepository)
    {        
        $user = $userRepository->find(1);//a remplacer par le user connecté
        $friends = $friendsRequestRepository->findMyFriends($user);    
         
        return $this->render('base/_friends.html.twig', [            
            'route_name' => $routeName,            
            'friends' => $friends            
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

    /**
     * @Route("/redirect-user", name="redirect_user")
     */
    public function redirectUser()
    {
        //dd($this->getUser()->getRoles());
        //dd($this->isGranted('ROLE_ADMIN'));

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        elseif ($this->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('member');
        }
        else {
            return $this->redirectToRoute('home');
        }
    }
}
