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

#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CartController extends AbstractController
{
    // injection par constructeur
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private CartService $cartService,
        private ProductRepository $productRepository)
    {  
    }
    
    #[Route('/cart', name: 'app_cart')]
    public function showCart(
    ): Response {

        $cartDetails = $this->cartService->getCartDetails($this->productRepository);
        $totalPrice = $this->cartService->getTotalPrice($this->productRepository);
        $form = $this->createForm(ValidateCartFormType::class);

        return $this->render('cart/cart.html.twig', [
            'cartDetails' => $cartDetails,
            'totalPrice' => $totalPrice,
            'validateCartForm' => $form->createView(),
        ]);
    }

    #[Route('/clear-cart', name: 'app_clear_cart')]
    public function clearCart(): Response
    {
        $this->cartService->clear();
        $this->addFlash('success', 'Le panier a été vidé avec succès !');
        
        return $this->redirectToRoute('app_home');
    }

    #[Route('/remove-cart/{id}', name: 'app_remove_cart')]
    public function removeCart(Product $product): Response
    {
        $this->cartService->remove($product);
        $this->addFlash('success', 'Le produit a été supprimé du panier !');
        
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/validate-cart', name: 'app_validate_cart')]
    public function validateCart(
        Request $request,
    ): Response {

        $cartDetails = $this->cartService->getCartDetails($this->productRepository);
        $totalPrice = $this->cartService->getTotalPrice($this->productRepository);

        // create a new order 
        $order = new Order();
        $order->setUser($this->getUser());
        $order->setPaidPrice($totalPrice);
        $order->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ValidateCartFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($order);

            // create a new orderline
            foreach ($cartDetails as $oneCart) {
                $orderline = new OrderLine();
                $orderline->setOrderGoodies($order);
                $orderline->setProduct($oneCart['product']);
                $orderline->setQuantity($oneCart['quantity']);

                $this->entityManager->persist($orderline);
            }

            // save all to DB
            $this->entityManager->flush();
            $this->cartService->clear();

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
