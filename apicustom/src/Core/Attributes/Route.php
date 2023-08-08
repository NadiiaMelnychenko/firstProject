<?php

namespace App\Core\Attributes;
use Attribute;

#[Attribute]
class Route
{
    protected $path;
    protected $method;

    public function __construct($path, $method = "GET")
    {
        $this->path = $path;
        $this->method = $method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }
}