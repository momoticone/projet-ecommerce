<?php

namespace App\Controller\Admin\Product;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListProductController extends AbstractController
{
/**
 * @Route("admin/produit/list", name="list_product")
 */
    public function list(ProductRepository $productRepository, Request $request,
                            PaginatorInterface $paginatorInterface): Response
    {
        $data = $productRepository->findAll();

        $products = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page',1),5
        );

        return $this->render('admin/product/list_produit.html.twig', [
            'products' => $products
        ]);
    }
}