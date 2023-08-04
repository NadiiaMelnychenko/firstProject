<?php
class NewsController{
    /**
     * @return Response
     */
    public function list() : Response
    {
        return new Response('List', "List!!!");
    }

    /**
     * @return Response
     */
    public function add() : Response
    {
        return new Response('Add', "Add!!!");
    }

    /**
     * @return Response
     */
    public function index() : Response
    {
        return new Response('Index', "Index!!!");
    }
}