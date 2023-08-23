<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
     * @return JsonResponse
     */
    #[Route(path: "test", name: "app_test")]
//    #[IsGranted("ROLE_ADMIN")]
    public function test(): JsonResponse
    {
        $user = $this->getUser();

//        $this->denyAccessUnlessGranted($user);
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            return new JsonResponse($products);
        }

//            throw new AccessDeniedException();
        return new JsonResponse($this->fetchProductsForUser($products));
    }

    /**
     * @param array $products
     * @return array
     */
    public function fetchProductsForUser(array $products): array
    {
        $fetchedProductsForUser = null;

        /** @var Product $product */
        foreach ($products as $product) {
            $tmpProductData = $product->jsonSerialize();

            unset($tmpProductData['description']);
            $fetchedProductsForUser[] = $tmpProductData;
        }
        return ($fetchedProductsForUser);
    }
}