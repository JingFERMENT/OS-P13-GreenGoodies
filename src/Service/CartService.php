<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{

    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function add(Product $product, int $quantity): void
    {
        // Logic to add the product to the cart with the specified quantity
        $cart = $this->session->get('cart', []);

        $productId = $product->getId();
        $this->remove($product);

        $cart[$productId] = $quantity; // Add new product to cart

        $this->session->set('cart', $cart);
    }

    public function getCart(): array
    {
        // Logic to retrieve the current cart contents
        return $this->session->get('cart', []);
    }

    public function getCartDetails(ProductRepository $productRepository): array
    {
        $cart = $this->getCart();
        $cartDetails = [];

        // $user = $security->getUser();

        foreach ($cart as $productID => $quantity) {
            $product = $productRepository->find($productID);
            if (!$product) {
                continue; // Ignorer les produits supprimés de la BDD
            }
            $totalPriceOfOneProduct = $product->getPrice() * $quantity;
            
            $cartDetails[] = [
                'product' => $product,
                'quantity' => $quantity,
                'totalPriceOfOneProduct' => $totalPriceOfOneProduct,
            ];
        }

        return $cartDetails;
    }

    public function getTotalPrice(ProductRepository $productRepository){
        $totalPrice = 0;

        foreach ($this->getCartDetails($productRepository) as $oneCart) {
            $totalPrice +=$oneCart['totalPriceOfOneProduct'];    
        }

        return $totalPrice;
    }

    public function remove(Product $product): void
    {
        // Logic to remove the product from the cart
        $cart = $this->session->get('cart', []);
        $productId = $product->getId();

        if (isset($cart[$productId])) {
            unset($cart[$productId]); // Remove product from cart
            $this->session->set('cart', $cart);
        }
    }

    public function clear(): void
    {
        // Logic to clear the cart
        $this->session->remove('cart');
    }
}
