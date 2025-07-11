<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product', requirements: ['id' => '\d+'])]
    public function show(ProductRepository $productRepository, int $id): Response
    {

        $product = $productRepository->find($id);
        
        return $this->render('product/product.html.twig', [
             'product' => $product,
        ]);
    }
}
