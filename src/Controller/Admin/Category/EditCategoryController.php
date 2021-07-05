<?php

namespace App\Controller\Admin\Category;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditCategoryController extends AbstractController
{

    /**
     * @Route("admin/category/edit/{id}", name="edit_category")
     */

     public function edit($id, Request $request,EntityManagerInterface $em,
                            CategoryRepository $categoryRepository)
     {
            $category = $categoryRepository->find($id);

            if(!$category)
            {
                $this->addFlash('danger', 'Cette category existe pas');
                return $this->redirectToRoute('list_category');
            }

            $imageOriginal = $category->getImageUrl();

            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $image = $form->get('imageUrl')->getData();

                if($image !== null)
                {
                    $file = md5(uniqid()).'.'.$image->guessExtension();
    
                    $image->move(
                        $this->getParameter('app_images_directory'),
                        $file
                    );
                    $category->setImageUrl('/upload/'.$file);
                    
                    if($imageOriginal !== null)
                    {
                        $fileImageOriginal = $this->getParameter('app_images_directory'). '/..'. $imageOriginal;

                        if(file_exists($fileImageOriginal))
                        {
                            unlink($fileImageOriginal);
                        }
                    }
    
                }
                $em->flush();

                $this->addFlash('succes', 'la categorie'.$category->getName().'a bien ete modifier.');
                return $this->redirectToRoute('list_category');


            }

            return $this->render('admin/category/edit_category.html.twig', [
                'formCategory' => $form->createView()
            ]);

     }

}