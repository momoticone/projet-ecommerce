<?php
namespace App\Controller\Admin\Product;

use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemoveProductController extends AbstractController
{
    /**
     * @Route("/admin/product/remove/{id}", name="product_remove")
     */

     public function productRemove($id,EntityManagerInterface $em,ProductRepository $productRepository, DeleteImageService $deleteImageService): RedirectResponse
     {
        $produitToRemove = $productRepository->find($id);

        if(!$produitToRemove)
        {
           $this->addFlash('danger', 'Ce Produit n\'existe pas en bdd.');
           return $this->redirectToRoute('list_category');

        }
        $deleteImageService->deleteImage($produitToRemove->getImageUrl(),$this->getParameter('app_images_directory'));

        $em->remove($produitToRemove);
        $em->flush();

        $this->addFlash('success', 'Votre produit a bien été Supprimer');
        return $this->redirectToRoute('list_product');
     }
}
