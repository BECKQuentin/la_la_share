<?php

namespace App\Controller\Admin;

use App\Entity\Musics;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        

        return $this->render('admin/index.html.twig', [            

        ]);
    }

    /**
    * @Route("/delete-member/{id}", name="delete_member")
    */
    public function deleteMember(User $user): Response
    {
        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($user);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé ".$user->getPseudo()." !");
        return $this->redirectToRoute('all_members', [

        ]);
    }

    /**
    * @Route("/delete-music/{id}", name="delete_music")
    */
    public function deleteMusic(Musics $musics): Response
    {        
        $em = $this->getDoctrine()->getManager();        
        $em->remove($musics);
        $em->flush();        
        
        $this->addFlash('danger', "Vous avez supprimé ".$musics->getTitle()." !");
        return $this->redirectToRoute('all_members', [

        ]);
    }
    

}
