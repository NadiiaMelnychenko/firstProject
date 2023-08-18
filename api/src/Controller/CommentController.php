<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Comment;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
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
    #[Route('comment', name: 'comment_list')]
    public function index(): JsonResponse
    {
        $comments = $this->entityManager->getRepository(Comment::class)->findAll();
        return new JsonResponse($comments);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/read/{id}', name: 'comment_get_item')]
    public function read(string $id): JsonResponse
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        if (!$comment)
            throw new Exception("There is no comment with id " . $id);

        return new JsonResponse($comment);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/book/{id}', name: 'all_book_comments')]
    public function readBookComments(string $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(Book::class)->find($id);
        if (!$book)
            throw new Exception("There is no book with id " . $id);
        $comment = $this->entityManager->getRepository(Comment::class)->getCommentsByBookId($id);
        return new JsonResponse($comment);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/create', name: 'create_comment')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['text'],
            $requestData['user'],
            $requestData['book']
        ))
            throw new Exception("Put values");

        $user = $this->entityManager->getRepository(User::class)->find($requestData['user']);

        if (!$user)
            throw new Exception("There is no user with id " . $requestData['user']);

        $book = $this->entityManager->getRepository(Book::class)->find($requestData['book']);
        if (!$book)
            throw new Exception("There is no book with id " . $requestData['genre']);

        $comment = new Comment();
        date_default_timezone_set('Europe/Kiev');
        $date = new DateTimeImmutable();
        $comment
            ->setText($requestData['text'])
            ->setUser($user)
            ->setDate($date)
            ->setBook($book);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return new JsonResponse($comment, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/update/{id}', name: 'update_comment')]
    public function update(string $id): JsonResponse
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);

        if (!$comment)
            throw new Exception("There is no comment with id " . $id);

        $comment->setText("new text!");
        $this->entityManager->flush();

        return new JsonResponse($comment);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/update/text/{id}', name: 'update_comment_text')]
    public function updateText(string $id): JsonResponse
    {
        $comment = $this->entityManager->getRepository(Book::class)->find($id);

        if (!$comment)
            throw new Exception("There is no comment with id " . $id);

        $comment->setText($comment->getText() . "new text!!!!!!");
        $this->entityManager->flush();

        return new JsonResponse($comment);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('comment/delete/{id}', name: 'comment_delete')]
    public function delete(string $id): JsonResponse
    {
        $comment = $this->entityManager->getRepository(Comment::class)->find($id);
        if (!$comment)
            throw new Exception("There is no comment with id " . $id);
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return new JsonResponse($this->entityManager->getRepository(Comment::class)->findAll());
    }
}
