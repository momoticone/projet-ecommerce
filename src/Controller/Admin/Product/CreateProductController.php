<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateProductController extends AbstractController
{

    /**
     * @Route("admin/product/create", name="create_product")
     */
    public function create(Request $request, EntityManagerInterface $em ): Response 
    {
        $form = $this->createForm(ProductType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /** @var Product $product */
            $product = $form->getData();

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
                $product->setImageUrl('/uploads/'.$file);

            }
            $em->persist($product);
            $em->flush();

            $this->addFlash('succes', 'Votre produit a bien ete crée');
            return $this->redirectToRoute('list_product');
        }
        return $this->render('admin/product/create_product.html.twig',[
            'formProduct' => $form->createView()
        ]);
    }
}