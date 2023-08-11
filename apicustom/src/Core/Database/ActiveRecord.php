<?php

namespace App\Core\Database;

use Cassandra\Date;
use Symfony\Component\VarDumper\Cloner\Data;

class ActiveRecord
{
    protected $fields = [];
    protected Database $database;

    function __construct(Database $database)
    {
        $this->database = $database;
    }

    # Магічні методи для приписування неіснуючих полів
    function __set(string $name, $value): void
    {
        $this->fields[$name] = $value;
    }

    function __get(string $name)
    {
        return $this->fields[$name];
    }

    # Для виклику неіснуючих методів
    function __call(string $name, array $arguments){
        switch ($name){
            case 'save':
                $builder = new QueryBuilder();
                $builder->insert($this->fields, $arguments[1]);
                    //->from($arguments[0]);
        }
    }
}
