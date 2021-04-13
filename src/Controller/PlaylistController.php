<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\User;
use App\Repository\PlaylistRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlist", name="playlist")
     */
    public function index(PlaylistRepository $playlistRepository): Response
    {
        $user = $this->getUser()->getId();        

        $playlists = $playlistRepository->findAllPlaylists($user);

        return $this->render('playlist/playlist.html.twig', [
            'playlists' => $playlists
        ]);
    }


}
