<?php
namespace App\Controller\Admin\Product;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowProductController extends AbstractController 
{
    /**
     * @Route("/product/show/{slug}", name="show_product")
     */
    public function show(string $slug,ProductRepository $productRepository): Response
    {
    
    
        $product = $productRepository->findOneBy(['slug' => $slug]);
// $article est une instance de Article


        return $this->render('public/product/show_product.html.twig', [
            'product' => $product
        ]);
    }
}