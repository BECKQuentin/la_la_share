<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\User;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use App\Repository\UserRepository;
use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

    /**
    * @Route("/playlist/add", name="add_playlist")
    * @IsGranted("ROLE_USER", message="Seuls les utilisateurs peuvent ajouter des playlists")
    */
    public function playlistCreate(Request $request, UploadService $uploadService)
    {
        $playlist= new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $fileName = $uploadService->uploadImage($image, $playlist);
                $playlist->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($playlist);
            $em->flush();

            $this->addFlash('success', "La playlist a bien été ajoutée");
            return $this->redirectToRoute('playlist');
        }

        return $this->render('playlist/addPlaylist.html.twig', [
            'form' => $form->createView(),
            'playlist' => $playlist
        ]);
    }


}
