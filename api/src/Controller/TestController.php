<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request): JsonResponse
    {
        $test = ['test'=>1];
        //dd($request->request->all()); - дані з post (form-data) запиту
        //dd($request->query->all()); - дані з get (form-data) запиту
        //dd($request->getContent()); #- повертає рядок
        //json_decode($request->getContent(), true (асоціативний масив))
        $requestData = json_decode($request->getContent(), true);

        return new JsonResponse($test);
    }
}
