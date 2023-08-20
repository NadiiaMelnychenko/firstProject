<?php

namespace App\Controller;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
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
    #[Route('genre', name: 'genre_list')]
    public function index(): JsonResponse
    {
        $genres = $this->entityManager->getRepository(Genre::class)->findAll();

        return new JsonResponse($genres);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('genre/read/{id}', name: 'genre_get_item')]
    public function read(string $id): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genre::class)->find($id);

        if (!$genre) {
            throw new Exception("There is no genre with id " . $id);
        }

        return new JsonResponse($genre);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('genre/create', name: 'create_genre')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['type'])) {
            throw new Exception("Put type");
        }

        $genre = new Genre();
        $genre
            ->setType($requestData['type'])
            ->setDescription($requestData['description'] ?? null);

        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        return new JsonResponse($genre, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('genre/update/{id}', name: 'update_genre')]
    public function update(string $id): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genre::class)->find($id);

        if (!$genre) {
            throw new Exception("There is no genre with id " . $id);
        }

        $genre->setDescription("some text");
        $this->entityManager->flush();

        return new JsonResponse($genre);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('genre/delete/{id}', name: 'genre_delete')]
    public function delete(string $id): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genre::class)->find($id);

        if (!$genre) {
            throw new Exception("There is no genre with id " . $id);
        }

        $this->entityManager->remove($genre);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
