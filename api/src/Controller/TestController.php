<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
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

    #[Route(path: "test", name: "app_test")]
    public function test(Request $request): JsonResponse
    {
        $pass = '123456';
        $user = new User();
        $user->setEmail("admin@gmail.com");



    }


//    /**
//     * @param Request $request
//     * @return JsonResponse
//     * @throws Exception
//     */
//    #[Route(path: "test", name: "app_test")]
//    public function test(Request $request): JsonResponse
//    {
//        $requestData = $request->query->all();
//
//        $books = $this->entityManager
//            ->getRepository(Book::class)
//            ->getAllBooksByParams(
//                $requestData["itemsPerPage"] ?? 30,
//                $requestData["page"] ?? 1,
//                array_diff_key($requestData, ["itemsPerPage" => null, "page" => null])
//            );
//
//        return new JsonResponse($books);
//    }
}
//            $requestData["itemsPerPage"] ?? 30,
//            $requestData["page"] ?? 1,
//            $requestData["genreType"] ?? null,
//            $requestData["id"] ?? null,
//            $requestData["title"] ?? null,
//            $requestData["author"] ?? null,
//            $requestData["plot"] ?? null,
//            $requestData["text"] ?? null,
//            $requestData["date"] ?? null,
//            $requestData["visible"] ?? null,
//            $requestData["price"] ?? null,