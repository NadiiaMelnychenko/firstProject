<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
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

    #[Route('product-create', name: 'product_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['name'], $requestData['price'], $requestData['description'])) {
            throw new \Exception("Invalid data");
        }

        $product = new Product();

        $product->setName($requestData['name']);
        $product->setPrice($requestData['price']);
        $product->setDescription($requestData['description']);

        $this->entityManager->persist($product);
        $this->entityManager->flush();


        return new JsonResponse();
    }

    /**
     * @return JsonResponse
     */
    #[Route('product-all', name: 'product_all')]
    public function read( ): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

//        //Виведення об'єктів
//        $tmpResponse = null;
//        /** @var  Product $product */
//        foreach ($products as $product) {
//            $tmpResponse[] = [
//                "name" => $product->getName(),
//                "price" => $product->getPrice(),
//                "description" => $product->getDescription()
//            ];
//        }


        return new JsonResponse($products);
    }
    /**
     * @return JsonResponse
     */
    #[Route('product/{id}', name: 'product_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            throw new Exception("Product with id " .$id. " not found");
        }

        return new JsonResponse($product);
    }
    /**
     * @return JsonResponse
     */
    #[Route('product-update/{id}', name: 'product_update_item')]
    public function updateProduct(string $id): JsonResponse
    {
        /** @var Product $product */
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            throw new Exception("Product with id " .$id. " not found");
        }

        $product->setName("New name");
        $this->entityManager->flush();

        return new JsonResponse($product);
    }
    /**
     * @return JsonResponse
     */
    #[Route('product-delete/{id}', name: 'product_delete_item')]
    public function deleteProduct(string $id): JsonResponse
    {
        /** @var Product $product */
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if(!$product){
            throw new Exception("Product with id " .$id. " not found");
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}


/*//function index(Request $request): JsonResponse
       $test = ['test'=>1];
       //dd($request->request->all()); - дані з post (form-data) запиту
       //dd($request->query->all()); - дані з get (form-data) запиту
       //dd($request->getContent()); #- повертає рядок
       //json_decode($request->getContent(), true (асоціативний масив))
       $requestData = json_decode($request->getContent(), true);
       return new JsonResponse($test);*/
