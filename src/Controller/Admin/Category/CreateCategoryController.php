<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateCategoryController extends AbstractController
{

    /**
     * @Route("admin/category/create", name="create_category")
     */
    public function create(Request $request, EntityManagerInterface $em ): Response 
    {
        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /** @var Category $category */
            $category = $form->getData();

            //Je recuper l'image
            $image = $form->get('imageUrl')->getData();
            //je verifie que l'image existe
            if($image !== null)
            {
                $file = md5(uniqid()).'.'.$image->guessExtension();

                $image->move(
                    $this->getParameter('app_images_directory'),
                    $file
                );
                $category->setImageUrl('/upload/'.$file);

            }
            $em->persist($category);
            $em->flush();

            $this->addFlash('succes', 'Votre categorie a bien ete crée');
            return $this->redirectToRoute('list_category');
        }
        return $this->render('admin/category/create_category.html.twig',[
            'formCategory' => $form->createView()
        ]);
    }
}