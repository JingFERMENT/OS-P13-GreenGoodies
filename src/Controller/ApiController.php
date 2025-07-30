<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ApiController extends AbstractController
{
    #[Route('/api/products', name: 'app_api_products', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();

        $jsonProducts = $serializer->serialize($products, 'json');

        return new JsonResponse(
            $jsonProducts,
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/activateApi', name: 'app_activate_api', methods: ['POST'])]
    public function activateApi(Security $security, 
    EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        if ($user->isActivatedAPI()) {
            $user->setIsActivatedAPI(false);
        } else {
            $user->setIsActivatedAPI(true);
        };

        $entityManager->flush();

        return $this->redirectToRoute('app_my_account');
    }
}
