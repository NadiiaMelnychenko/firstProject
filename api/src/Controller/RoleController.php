<?php

namespace App\Controller;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
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
    #[Route('role', name: 'role_list')]
    public function index(): JsonResponse
    {
        $roles = $this->entityManager->getRepository(Role::class)->findAll();

        return new JsonResponse($roles);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('role/read/{id}', name: 'role_get_item')]
    public function read(string $id): JsonResponse
    {
        $role = $this->entityManager->getRepository(Role::class)->find($id);

        if (!$role) {
            throw new Exception("There is no role with id " . $id);
        }

        return new JsonResponse($role);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('role/create', name: 'create_role')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData['role'])) {
            throw new Exception("Put role name");
        }

        $role = new Role();
        $role->setRole($requestData['role']);

        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return new JsonResponse($role, Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('role/update/{id}', name: 'update_role')]
    public function update(string $id): JsonResponse
    {
        $role = $this->entityManager->getRepository(Role::class)->find($id);

        if (!$role) {
            throw new Exception("There is no role with id " . $id);
        }

        $role->setRole("admin2");
        $this->entityManager->flush();

        return new JsonResponse($role);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('role/delete/{id}', name: 'role_delete')]
    public function delete(string $id): JsonResponse
    {
        $role = $this->entityManager->getRepository(Role::class)->find($id);

        if (!$role) {
            throw new Exception("There is no role with id " . $id);
        }

        $this->entityManager->remove($role);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
