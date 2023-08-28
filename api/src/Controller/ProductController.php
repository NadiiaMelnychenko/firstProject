<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, DenormalizerInterface $denormalizer)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/products', name: 'app_products', methods: "GET")]
    public function index(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return new JsonResponse($products);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws ExceptionInterface
     */
    #[Route('/products', name: 'create_product', methods: "POST")]
    #[IsGranted("ROLE_ADMIN")]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['name'],
            $requestData['price'],
        )) {
            throw new Exception("Put values");
        }

        $product = $this->denormalizer->denormalize($requestData, Product::class, "array");

        $product
            ->setName($requestData['name'])
            ->setDescription($requestData['description'] ?? "")
            ->setPrice($requestData["price"]);

        $this->printErrors($product);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return new JsonResponse($product, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'product_get_item', methods: "GET")]
    public function read(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($product);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'product_delete_item', methods: "DELETE")]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'update_product', methods: "PUT")]
    #[IsGranted("ROLE_ADMIN")]
    public function update(string $id, Request $request): JsonResponse
    {
        $requestData = $request->query->all();
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new NotFoundHttpException('Product not found for id ' . $id);
        }

        $metadata = $this->entityManager->getClassMetadata(Product::class);
        $validFields = array_keys($metadata->fieldMappings);

        foreach ($requestData as $field => $value) {

            if (!in_array($field, $validFields)) {
                throw new NotFoundHttpException('Don`t have such field');
            }

            $setter = 'set' . ucfirst($field);

            if (method_exists($product, $setter)) {
                $errors = $this->validator->validatePropertyValue(Product::class, $field, $value);

                if (count($errors) > 0) {
                    return new JsonResponse((string)$errors, 400);
                }

                $product->$setter($value);
            }
        }

        $this->entityManager->flush();

        return new JsonResponse($product);
    }

    /**
     * @param $product
     * @return JsonResponse|void
     */
    public function printErrors($product)
    {
        $errors = $this->validator->validate($product);

        if (count($errors) > 0) {
            return new JsonResponse((string)$errors);
        }
    }
}