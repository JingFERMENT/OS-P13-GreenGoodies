<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\Product;
use App\Form\ValidateCartFormType;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CartController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/cart', name: 'app_cart')]
    public function showCart(
        Security $security,
        CartService $cartService,
        ProductRepository $productRepository,
    ): Response {

        $user = $security->getUser();

        $cartDetails = $cartService->getCartDetails($productRepository);

        $totalPrice = $cartService->getTotalPrice($productRepository);

        $form = $this->createForm(ValidateCartFormType::class);

        return $this->render('cart/cart.html.twig', [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice,
            'validateCartForm' => $form->createView(),
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/clear-cart', name: 'app_clear_cart')]
    public function clearCart(CartService $cartService): Response
    {
        $cartService->clear();
        $this->addFlash('success', 'Le panier a été vidé avec succès !');
        return $this->redirectToRoute('app_home');
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/remove-cart/{id}', name: 'app_remove_cart')]
    public function removeCart(CartService $cartService, Product $product): Response
    {
        $cartService->remove($product);
         $this->addFlash('success', 'Le produit a été supprimé du panier avec succès !');
        return $this->redirectToRoute('app_cart');
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/validate-cart', name: 'app_validate_cart')]
    public function validateCart(
        CartService $cartService,
        ProductRepository $productrepository,
        Security $security,
        EntityManagerInterface $entityManager,
        Request $request,
    ): Response {

        $user = $security->getUser();

        $cartDetails = $cartService->getCartDetails($productrepository);

        $totalPrice = $cartService->getTotalPrice($productrepository);

        // create a new order 
        $order = new Order();
        $order->setUser($user);
        $order->setPaidPrice($totalPrice);
        $order->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ValidateCartFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        return $this->render('cart/cart.html.twig', [
        'cartDetails' => $cartDetails,
        'totalPrice' => $totalPrice,
        'validateCartForm' => $form->createView(),
    ]);
    }
}
