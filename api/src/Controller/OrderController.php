<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    #[Route('/orders', name: 'order_list', methods: 'GET')]
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
        $fetchedOrdersForUser = [];

        /** @var Order $order */
        foreach ($orders as $order) {
            /** @var User $user */
            if ($order->getUser()?->getId() === $user->getId()) {
                $tmp = $order->jsonSerialize();
                unset($tmp['user']);
                $fetchedOrdersForUser[] = $tmp;
            }
        }

        return $fetchedOrdersForUser;
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/orders/{id}', name: 'order_get_item', methods: 'GET')]
    #[IsGranted('ROLE_USER')]
    public function read(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new Exception("There is no order with id " . $id);
        }

        $this->checkUser($order, $user);

        return new JsonResponse($order);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/orders', name: 'create_order', methods: 'POST')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $user = $this->getUser();

        if (!isset(
            $requestData['products']
        )) {
            throw new Exception("Put values");
        }

        $productsArray = explode(',', $requestData['products']);

        $productsInOrder = null;

        $order = new Order();

        foreach ($productsArray as $item) {
            $checkProduct = $this->entityManager->getRepository(Product::class)->find($item);

            if (!$checkProduct) {
                throw new NotFoundHttpException();
            }

            $order->addProduct($checkProduct);
            $productsInOrder[] = $checkProduct;
        }

        $orderSum = $this->countOrderSum($productsInOrder);

        $order
            ->setSum($orderSum)
            ->setProductsAmount(count($productsInOrder))
            ->setUser($user);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return new JsonResponse($order, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/orders/{id}', name: 'update_order', methods: 'PUT')]
    #[IsGranted('ROLE_USER')]
    public function update(string $id, Request $request): JsonResponse
    {
        $requestData = $request->query->all();
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new Exception("There is no order with id " . $id);
        }

        $this->checkUser($order, $user);

        if (array_key_exists('add', $requestData)) {
            $product = $this->entityManager->getRepository(Product::class)->find($requestData['add']);
            $order->addProduct($product);
        }
        if (array_key_exists('remove', $requestData)) {
            $product = $this->entityManager->getRepository(Product::class)->find($requestData['remove']);
            $order->removeProduct($product);
        }

        $this->updateOrderSum($order);

        $this->entityManager->flush();

        return new JsonResponse($order);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/orders/{id}', name: 'order_delete', methods: 'DELETE')]
    #[IsGranted('ROLE_USER')]
    public function delete(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);
        $user = $this->getUser();

        if (!$order) {
            throw new NotFoundHttpException();
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
            throw new NotFoundHttpException();
        }
    }

    /**
     * @param $products
     * @return int|string|null
     */
    public function countOrderSum($products): int|string|null
    {
        $sum = 0;
        foreach ($products as $product) {
            /** @var Product $product */
            $price = $product->getPrice();
            $sum += $price;
        }
        return $sum;
    }

    /**
     * @param $order
     * @return void
     */
    public function updateOrderSum($order): void
    {
        $sum = 0;
        $amount = 0;

        /** @var Order $order */
        foreach ($order->getProducts() as $product) {
            /** @var Product $product */
            $price = $product->getPrice();
            $sum += $price;
            $amount++;
        }

        $order
            ->setSum($sum)
            ->setProductsAmount($amount);
    }
}