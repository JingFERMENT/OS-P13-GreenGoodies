<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use App\Form\CartQuantityFormType;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function showCart(CartService $cartService, ProductRepository $productRepository): Response
    {
        $cartDetails = $cartService->getCartDetails($productRepository);
       
        $totalPrice = $cartService->getTotalPrice($productRepository);

        return $this->render('cart/cart.html.twig', [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/clear-cart', name: 'app_clear_cart')]
    public function clearCart(CartService $cartService): Response
    {
        $cartService->clear();
        return $this->redirectToRoute('app_home');
    }

    #[Route('/validate-cart', name: 'app_validate_cart')]
    public function validateCart(
        Request $request,
        CartService
        $cartService,
        ProductRepository $productrepository,
        Security $security,
        EntityManagerInterface $entityManager
    ): Response {

        $user = $security->getUser();

        $cartDetails = $cartService->getCartDetails($productrepository);

        $totalPrice = $cartService->getTotalPrice($productrepository);

        // create a new order 
        $order = new Order();
        $order->setUser($user);
        $order->setPaidPrice($totalPrice);
        $order->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($order);

        // create a new orderline
        foreach ($cartDetails as $oneCart) {
            $orderline = new OrderLine();
            $orderline->setOrderGoodies($order);
            $orderline->setProduct($oneCart['product']);
            $orderline->setQuantity($oneCart['quantity']);

            $entityManager->persist($orderline);
        }

        // save all to DB
        $entityManager->flush();

        $cartService->clear();

        $this->addFlash('success', 'Votre commande a été validée avec succès !');
        return $this->redirectToRoute('app_home');
    }
}
