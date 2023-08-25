<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Order;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
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
    #[Route('orders', name: 'order_list')]
    public function index(): JsonResponse
    {
        $user = $this->getUser();

        $orders = $this->entityManager->getRepository(Order::class)->findAll();

        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            return new JsonResponse($orders);
        }

        return new JsonResponse($this->fetchOrdersForUser($orders, $user));
    }

    /**
     * @param $orders
     * @param $user
     * @return array
     */
    public function fetchOrdersForUser($orders, $user): array
    {
        $fetchedOrdersForUser = null;

        if (!is_array($orders)) {
            /** @var User $user */
            if ($orders->getUser()?->getId() === $user->getId()) {
                $fetchedOrdersForUser[] = $orders->jsonSerialize();
            }

            return ($fetchedOrdersForUser);
        }

        /** @var Order $order */
        foreach ($orders as $order) {
            /** @var User $user */
            if ($order->getUser()?->getId() === $user->getId()) {
                $fetchedOrdersForUser[] = $order->jsonSerialize();
            }
        }

        return ($fetchedOrdersForUser);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order/read/{id}', name: 'order_get_item')]
    #[IsGranted('ROLE_USER')]
    public function read(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new Exception("There is no order with id " . $id);
        }

        $this->checkUser($order, $user);

        return new JsonResponse($this->fetchOrdersForUser($order, $user));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order/create', name: 'create_order')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if (!isset(
            $requestData['books']
        )) {
            throw new Exception("Put values");
        }

        $booksArray = explode(',', $requestData['books']);

        $booksInOrder = null;
        $orderSum = 0;

        foreach ($booksArray as $book) {
            $checkBook = $this->entityManager->getRepository(Book::class)->find($book);

            if (!$checkBook) {
                throw new Exception("There is no book with id " . $book);
            }

            $booksInOrder[] = $checkBook->getId();
            $orderSum += $checkBook->getPrice();
        }

        date_default_timezone_set('Europe/Kiev');
        $date = new DateTimeImmutable();

        $try = json_encode($booksInOrder);

        $order = new Order();
        $order
            ->setBooks($try)
            ->setSum($orderSum)
            ->setTime($date)
            ->setUser($user);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return new JsonResponse($order, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order/update/{id}', name: 'update_order')]
    #[IsGranted('ROLE_USER')]
    public function update(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new Exception("There is no order with id " . $id);
        }

        $this->checkUser($order, $user);

        $order->setSum(100);
        $this->entityManager->flush();

        return new JsonResponse($order);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order/delete/{id}', name: 'order_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new Exception("There is no order with id " . $id);
        }

        $this->checkUser($order, $user);

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @throws Exception
     */
    public function checkUser($order, $user): void
    {
        /** @var User $user */
        if ($order->getUser()?->getId() !== $user->getId()) {
            throw new Exception("This is not your order");
        }
    }
}
