<?php

namespace App\Controllers;

use App\Core\Response;
use App\Core\Attributes\Route;

class NewsController
{
    /**
     * @return Response
     */
    public function list(): Response
    {
        return new Response('List', "List!!!");
    }

    /**
     * @return Response
     */
    #[Route("addition")]
    public function add(): Response
    {
        return new Response('Add', "Add!!!");
    }

    /**
     * @return Response
     */
    #[Route("home")]
    public function index(): Response
    {
        return new Response('Index', "Index!!!");
    }
}