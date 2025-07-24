<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    private $session;

    public function __construct(RequestStack $requestStack) {
        $this->session = $requestStack->getSession();
    }
    
    public function add(Product $product, int $quantity): void
    {
        // Logic to add the product to the cart with the specified quantity
        $cart = $this->session->get('cart', []);
        
        $productId = $product->getId();

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity; // Increment quantity if product already in cart
        } else {
            $cart[$productId] = $quantity; // Add new product to cart
        }

        $this->session->set('cart', $cart);

    }

    public function getCart(): array
    {
        // Logic to retrieve the current cart contents
        return $this->session->get('cart', []);
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