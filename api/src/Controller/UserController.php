<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
    #[Route('user', name: 'user_list')]
    public function index(): JsonResponse
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        return new JsonResponse($users);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('user/read/{id}', name: 'user_get_item')]
    public function read(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new Exception("There is no user with id " . $id);
        }

        return new JsonResponse($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('user/create', name: 'create_user')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['name'],
            $requestData['login'],
            $requestData['password'],
            $requestData['role']
        )) {
            throw new Exception("Put values");
        }

        $role = $this->entityManager->getRepository(Role::class)->find($requestData['role']);

        if (!$role) {
            throw new Exception("There is no role with id " . $requestData['role']);
        }

        $user = new User();
        $user
            ->setName($requestData['name'])
            ->setLogin($requestData["login"])
            ->setPassword($requestData["password"])
            ->setAbout($requestData["about"] ?? "")
            ->setRole($role);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('user/update/{id}', name: 'update_user')]
    public function update(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new Exception("There is no user with id " . $id);
        }

        $user->setName("Anton");
        $this->entityManager->flush();

        return new JsonResponse($user);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('user/delete/{id}', name: 'user_delete')]
    public function delete(string $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw new Exception("There is no user with id " . $id);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
