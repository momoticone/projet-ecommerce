<?php
namespace App\Controller\Admin\Category;

use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemoveCategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/remove/{id}", name="category_remove")
     */

     public function categoryRemove(int $id,CategoryRepository $categoryRepository,EntityManagerInterface $em, 
                                       DeleteImageService $deleteImageService): RedirectResponse
     {
        $category = $categoryRepository->find($id);

        if(!$category)
        {
           $this->addFlash('danger', 'Cette categorie n\'existe pas en bdd.');
           return $this->redirectToRoute('list_category');

        }
        $deleteImageService->deleteImage($category->getImageUrl(),$this->getParameter('app_images_directory'));

        $em->remove($category);
        $em->flush();

        $this->addFlash('success', 'Votre produit a bien été Supprimer');
        return $this->redirectToRoute('list_category');
     }
}
