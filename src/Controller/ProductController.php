<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product', requirements: ['id' => '\d+'])]
    public function show(Product $product, CartService $cartService): Response
    {

        $cart = $cartService->getCart();

        return $this->render('product/product.html.twig', [
             'product' => $product,
             'cart' => $cart,
             'quantityOptions' => range(0, 5), // Options for quantity selection
        ]);
    }
}
