<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/add-to-cart/{id}', name: 'app_add_to_cart', methods: ['POST'])]
    public function addToCart(Product $product, Request $request, CartService $cartService): Response
    {
        $quantity = $request->request->get('quantity', 1);
      
        if($quantity > 0) {
            $cartService->add($product, $quantity);
        } 

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart', name: 'app_cart')]
    public function showCart(CartService $cartService, ProductRepository $productRepository): Response
    {
        $cart = $cartService->getCart();
    
        $cartDetails = [];
        $totalPrice = 0;
        foreach ($cart as $productID => $quantity) {
            
            $product = $productRepository->find($productID);
            $lineTotal = $product->getPrice() * $quantity;
            $cartDetails[] = [
                'product' => $product,
                'quantity' => $quantity,
                'totalOfOneProduct' => $lineTotal,
            ];

            $totalPrice += $lineTotal;
        }
        

        return $this->render('cart/cart.html.twig', [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice,
        ]);
    }

}