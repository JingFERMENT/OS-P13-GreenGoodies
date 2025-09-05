<?php

namespace App\Controller;

use App\Form\ActivateAPIFormType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class MyAccountController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private OrderRepository $orderRepository,
        private Security $security,
        private TokenStorageInterface $tokenStorage
    )
    {  

    }

    // Display all the details of the user's account
    #[Route('/my-account', name: 'app_my_account')]
    public function showAccount(): Response
    {
        $user = $this->security->getUser();

        $orders = $this->orderRepository->findByUser($user);

        $form = $this->createForm(ActivateAPIFormType::class, $user, [
            'action' => $this->generateUrl('app_activate_api'),
            'method' => 'POST',
        ]);

        // Render the form in the template
        return $this->render('my_account/my_account.html.twig', [
            'orders' => $orders,
            'activateApiForm' => $form->createView(),
        ]);
    }


    // Delete the account 
    #[Route('/delete-my-account', name: 'app_delete_my_account')]
    public function deleteAccount(
        Request $request  
    ): Response {

        $user = $this->security->getUser();

        // delete the orders and orderlines
        $orders = $user->getOrders();

        foreach ($orders as $order) {
            foreach ($order->getOrderlines() as $oneOrderLine) {
                $this->entityManager->remove($oneOrderLine);
            }
            $this->entityManager->remove($order);
        }

        // delete the user
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        //symfony garde en mémoire l’ancien token d’authentification  
        // il faudrait le vider pour déconnecter proprement
        $this->tokenStorage->setToken(null);

        // bonne pratique: invalider la session 
        // supprimer toutes les variables dans la session
        $request->getSession()->invalidate();

        return $this->redirectToRoute('app_login');
    }

    #[Route('/my-account/api/toggle', name: 'app_activate_api', methods: ['POST'])]
    public function toggleApi(
        Request $request
    ): Response {

        $form = $this->createForm(ActivateAPIFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();

            $user->setIsActivatedAPI(!$user->isActivatedAPI());
            
            $this->entityManager->flush();
             $this->addFlash('success', 'Votre accès API a été mis à jour.');
        }

        return $this->redirectToRoute('app_my_account');
    }
}
