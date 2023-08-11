<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Core\Attributes\Route;

class NewsController extends Controller
{
    /**
     * @return Response
     */
    public function list(): string
    {
        return $this->render(
            [
                'title' => 'text',
                'text' => 'some text'
            ]
        );
        //return new Response('List', "List!!!");
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

    public function render(array $assoc_array): string
    {
        $assoc_array['module'] = 'news';
        return parent::render($assoc_array);
    }


}