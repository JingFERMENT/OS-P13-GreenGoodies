<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class MyAccountController extends AbstractController
{
    // Display all the details of the user's account
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/my-account', name: 'app_my_account')]
    public function showAccount(OrderRepository $orderRepository, Security $security): Response
    {
        $user = $security->getUser();
        $orders = $orderRepository->findByUser($user);

        return $this->render('my_account/my_account.html.twig', [
            'orders' => $orders,
        ]);
    }


    // Delete the account 
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/delete-my-account', name: 'app_delete_my_account')]
    public function deleteAccount(
        Request $request,
        Security $security,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    ): Response {

        // delete the user
        $user = $security->getUser();
        $entityManager->remove($user);

        // delete the orders and orderlines
        $orders = $user->getOrders();

        foreach ($orders as $order) {
            foreach ($order->getOrderlines() as $oneOrderLine) {
                $entityManager->remove($oneOrderLine);
            }
            $entityManager->remove($order);
        }

        $entityManager->flush();
        
        //symfony garde en mémoire l’ancien token d’authentification  
        // il faudrait le vider pour déconnecter proprement
        $tokenStorage->setToken(null); 
        
        // bonne pratique: invalider la session 
        // supprimer toutes les variables dans la session
        $request->getSession()->invalidate();  
        
        return $this->redirectToRoute('app_login');
    }
}
