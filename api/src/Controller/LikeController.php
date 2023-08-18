<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Like;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
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
    #[Route('like', name: 'all_likes')]
    public function index(): JsonResponse
    {
        $likes = $this->entityManager->getRepository(Like::class)->findAll();

        return new JsonResponse($likes);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('like/user/{id}', name: 'user_likes')]
    public function userLikes(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new Exception("There is no user with id " . $id);
        }

        $likes = $this->entityManager->getRepository(Like::class)->findBy(["user" => $id]);

        return new JsonResponse($likes);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('like/book/{id}', name: 'book_likes')]
    public function bookLikes(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw new Exception("There is no book with id " . $id);
        }

        $likes = $this->entityManager->getRepository(Like::class)->findBy(["book" => $id]);

        return new JsonResponse($likes);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('like/create', name: 'create_like')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['user'],
            $requestData['book']
        )) {
            throw new Exception("Put values");
        }

        $user = $this->entityManager->getRepository(User::class)->find($requestData['user']);

        if (!$user) {
            throw new Exception("There is no user with id " . $requestData['user']);
        }

        $book = $this->entityManager->getRepository(Book::class)->find($requestData['book']);

        if (!$book) {
            throw new Exception("There is no book with id " . $requestData['book']);
        }

        $like = new Like();
        $like
            ->setUser($user)
            ->setBook($book);

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        return new JsonResponse($like, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('like/delete/{id}', name: 'like_delete')]
    public function delete(string $id): JsonResponse
    {
        $like = $this->entityManager->getRepository(Like::class)->find($id);

        if (!$like) {
            throw new Exception("There is no like with id " . $id);
        }

        $this->entityManager->remove($like);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
