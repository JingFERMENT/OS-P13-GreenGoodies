<?php

namespace App\Controller;

use App\Entity\OrderLine;
use App\Entity\Product;
use App\Form\CartQuantityFormType;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'app_product', requirements: ['id' => '\d+'])]
    public function show(Product $product, CartService $cartService, Request $request): Response
    {

        $cart = $cartService->getCart();

        $existingQuantity = $cart[$product->getId()] ?? 1;

        $orderLine = new OrderLine();
        $orderLine->setProduct($product);
        $orderLine->setQuantity($existingQuantity);

        $form = $this->createForm(CartQuantityFormType::class, $orderLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $cartService->add($product, $data->getQuantity());
            return $this->redirectToRoute('app_cart');
        }

        return $this->render('product/product.html.twig', [
            'product' => $product,
            'cart' => $cart,
            'cartQuantityForm' => $form,
        ]);
    }
}
