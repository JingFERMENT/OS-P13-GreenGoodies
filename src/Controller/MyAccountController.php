<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MyAccountController extends AbstractController
{
    // Display all the details of the user's account
    #[Route('/my-account', name: 'app_my_account')]
    public function showAccount(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        
        return $this->render('my_account/my_account.html.twig', [
            'orders' => $orders,
        ]);
    }


    // Delete the account 
    public function deleteAccount () 
    {

    }
}
