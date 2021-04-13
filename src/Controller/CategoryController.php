<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryType;
use App\Repository\CategorieRepository;
use App\Service\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category", name="category")
     */
    public function index(CategorieRepository $categoryRepository): Response
    {
        $categories= $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
    * @Route("/category/create", name="category_create")
    * @IsGranted("ROLE_ADMIN", message="Seuls les administrateurs peuvent ajouter des catégories")
    */
    public function categoryCreate(Request $request, UploadService $uploadService)
    {
        $category= new Categorie();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $fileName = $uploadService->uploadImage($image, $category);
                $category->setImage($fileName);
            }

            //dd($category);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', "La catégorie a bien été ajoutée");
            return $this->redirectToRoute('category');
        }

        return $this->render('category/addCategory.html.twig', [
            'form' => $form->createView()            
        ]);
    }
}
