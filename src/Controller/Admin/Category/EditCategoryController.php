<?php 

namespace App\Controller\Admin\Category;

use App\Form\CategoryType;
use App\MesServices\ImageServices\DeleteImageService;
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
    public function edit($id,Request $request,EntityManagerInterface $em,
                        CategoryRepository $categoryRepository,DeleteImageService $deleteImageService)
    {
        $category = $categoryRepository->find($id);

        if(!$category)
        {
            $this->addFlash('danger','Cette catégorie n\'existe pas !');
            return $this->redirectToRoute('list_category');
        }

        $imageOriginal = $category->getImageUrl();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $image = $form->get('imageUrl')->getData();

            //Je vérifie que l'image existe bel et bien.
            if($image !== null)
            {
                $file = md5(uniqid()) . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('app_images_directory'),
                    $file
                );

                $category->setImageUrl('/uploads/'. $file);

                //Processus de supression de l'image précédente
                $deleteImageService->deleteImage($imageOriginal,$this->getParameter('app_images_directory'));

            }

            $em->flush();

            $this->addFlash('success','La catégorie ' . $category->getName() . ' a bien été modifié.');
            return $this->redirectToRoute('list_category');
        }

        return $this->render('admin/category/edit_category.html.twig',[
            'formCategory' => $form->createView()
        ]);
    }
}