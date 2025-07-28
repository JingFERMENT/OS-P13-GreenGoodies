<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;


final class ApiController extends AbstractController
{
    #[Route('/api/products', name: 'app_api_products', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();

        $jsonProducts = $serializer->serialize($products, 'json');

        return new JsonResponse(
            $jsonProducts, Response::HTTP_OK, [], true
        );
    }
}
