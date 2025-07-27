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
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class MyAccountController extends AbstractController
{
    // Display all the details of the user's account
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/my-account', name: 'app_my_account')]
    public function showAccount(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

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
        EntityManagerInterface $entityManager
    ): Response {
        
        $user = $security->getUser();
        $entityManager->remove($user);

       



        // supprimer l'ordre 

        


        $entityManager->flush();
        
        $session = $request->getSession();
        $session->invalidate();
        return $this->redirectToRoute('app_login');
    }
}
