<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
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
    #[Route('book', name: 'book_list')]
    public function index(): JsonResponse
    {
        $books = $this->entityManager->getRepository(Book::class)->findAll();

        return new JsonResponse($books);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('book/read/{id}', name: 'book_get_item')]
    public function read(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$user) {
            throw new Exception("There is no book with id " . $id);
        }

        return new JsonResponse($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('book/create', name: 'create_book')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['title'],
            $requestData['plot'],
            $requestData['text'],
            $requestData['author'],
            $requestData['visible'],
            $requestData['genre']
        )) {
            throw new Exception("Put values");
        }

        $author = $this->entityManager->getRepository(User::class)->find($requestData['author']);

        if (!$author) {
            throw new Exception("There is no user with id " . $requestData['author']);
        }

        if ($author->getRole()->getRole() !== "author") {
            throw new Exception("Change your role to add the book.");
        }
        $genre = $this->entityManager->getRepository(Genre::class)->find($requestData['genre']);

        if (!$genre) {
            throw new Exception("There is no genre with id " . $requestData['genre']);
        }

        $book = new Book();
        date_default_timezone_set('Europe/Kiev');
        $date = new DateTimeImmutable();
        $book
            ->setTitle($requestData['title'])
            ->setPlot($requestData["plot"])
            ->setText($requestData["text"])
            ->setUser($author)
            ->setDate($date)
            ->setVisible($requestData["visible"])
            ->setGenre($genre);

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return new JsonResponse($book, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('book/update/{id}', name: 'update_book')]
    public function update(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw new Exception("There is no book with id " . $id);
        }

        $book->setText("new text!");
        $this->entityManager->flush();

        return new JsonResponse($book);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('book/update/text/{id}', name: 'update_book_text')]
    public function updateText(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw new Exception("There is no book with id " . $id);
        }

        $book->setText($book->getText() . "new text!!!!!!");
        $this->entityManager->flush();

        return new JsonResponse($book);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('book/delete/{id}', name: 'book_delete')]
    public function delete(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw new Exception("There is no book with id " . $id);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
