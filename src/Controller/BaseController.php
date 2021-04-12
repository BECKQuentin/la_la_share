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
        $connected = false;
        $friends = null;        

        if($this->IsGranted('ROLE_USER')) {
            $user = $this->getUser();   
            $friends = $friendsRequestRepository->findMyFriends($user);
            
            $connected = true;
        }        
        
        $admins = $userRepository->findAllAdmin();
        
        return $this->render('base/_friends.html.twig', [ 
            'route_name' => $routeName,   
            'connected' => $connected,    
            'friends' => $friends,
            'admins' => $admins          
        ]);     
    }

    //////////////////// HOME //////////////////////////
    /**
     * @Route("/", name="home")
     */
    public function home(MusicsRepository $musicsRepository): Response
    {
        $musics = $musicsRepository->findRecentMusics(6);
        return $this->render('base/home.html.twig', [
            'musics' => $musics
        ]);
    }

    /**
     * @Route("/redirect-user", name="redirect_user")
     */
    public function redirectUser()
    {
     
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
