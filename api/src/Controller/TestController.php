<?php

namespace App\Controller;

use App\Core\Response;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    #[Route(path: "test", name: "app_test")]
    public function test(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $requestData = json_decode($request->getContent(), true);

        $product = $this->denormalizer->denormalize($requestData, Product::class, "array");

        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
            return new JsonResponse((string)$errors);
        }

//        if (!isset($requestData['test'])) {
//            throw new BadRequestException();
//        }

        return new JsonResponse();
    }




//    /**
//     * @return JsonResponse
//     */
//    #[Route(path: "test", name: "app_test")]
////    #[IsGranted("ROLE_ADMIN")]
//    public function test(): JsonResponse
//    {
//        $user = $this->getUser();
//
////        $this->denyAccessUnlessGranted($user);
//        $products = $this->entityManager->getRepository(Product::class)->findAll();
//
//        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
//            return new JsonResponse($products);
//        }
//
////            throw new AccessDeniedException();
//        return new JsonResponse($this->fetchProductsForUser($products));
//    }
//
//    /**
//     * @param array $products
//     * @return array
//     */
//    public function fetchProductsForUser(array $products): array
//    {
//        $fetchedProductsForUser = null;
//
//        /** @var Product $product */
//        foreach ($products as $product) {
//            $tmpProductData = $product->jsonSerialize();
//
//            unset($tmpProductData['description']);
//            $fetchedProductsForUser[] = $tmpProductData;
//        }
//        return ($fetchedProductsForUser);
//    }
}