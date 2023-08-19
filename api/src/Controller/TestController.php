<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route(path: "test", name: "app_test")]
    public function test(Request $request): JsonResponse
    {
        $requestData = $request->query->all();

        $products = $this->entityManager->getRepository(Product::class)->getAllProductsByName(
            $requestData["itemsPerPage"] ?? 30,
            $requestData["page"] ?? 1,
            $requestData["categoryName"] ?? null,
            $requestData["name"] ?? null
        );

        return new JsonResponse($products);
    }
}