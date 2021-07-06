<?php
namespace App\Controller\Admin\Product;

use App\Form\ProductType;
use App\MesServices\ImageServices\DeleteImageService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProductController extends AbstractController
 {

    /**
     * @Route("admin/product/edit/{id}", name="edit_product")
     */

     public function edit($id, Request $request,EntityManagerInterface $em,
                            ProductRepository $productRepository, DeleteImageService $deleteImageService)
     {
        $product = $productRepository->find($id);

        if(!$product)
            {
              $this->addFlash('danger', "Ce produit n'existe pas");
              return $this->redirectToRoute('list_product');
            }

        $imageOriginal = $product->getImageUrl();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
            {
                $image =$form->get('imageUrl')->getData();
                if($image !== null)
                    {
                        $file = md5(uniqid()). '.' . $image->guessExtension();

                        $image->move(
                            $this->getParameter('app_images_directory'),
                            $file
                        );

                        $product->setImageUrl('/uploads/'.$file);

                        //Processus de supression de l'image précédente
                        $deleteImageService->deleteImage($imageOriginal,$this->getParameter('app_images_directory'));

                    }
                $em->flush();
                $this->addFlash('success','Le produit ' . $product->getName() . ' a bien été modifié.');
                return $this->redirectToRoute('list_product');
            }
            return $this->render('admin/product/edit_product.html.twig',[
                'formProduct' => $form->createView()
            ]);

     }
 }