<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final class ApiController extends AbstractController
{
    #[Route('/api/products', name: 'app_api_products', methods: ['GET'])]
    public function getAllProducts(
        ProductRepository $productRepository,
        SerializerInterface $serializer,
        Request $request,
        TagAwareCacheInterface $cachePool
    ): JsonResponse {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);

        $idCache = 'getAllProducts-' . $page . '-' . $limit;

        $products = $cachePool->get(
            $idCache,

            function (ItemInterface $item) use ($productRepository, $page, $limit) {
                $item->tag("booksCache");
                return $productRepository->findAllWithPagination($page, $limit);
            }
        );

        $jsonProducts = $serializer->serialize($products, 'json');

        return new JsonResponse(
            $jsonProducts,
            Response::HTTP_OK,
            [],
            true
        );
    }
}
