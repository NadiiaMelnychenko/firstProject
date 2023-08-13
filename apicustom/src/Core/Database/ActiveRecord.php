<?php

namespace App\Core\Database;

use App\Core\Core;
use App\Core\StaticCore;

class ActiveRecord
{
    protected array $fields = [];
    protected string $table;
    protected Database $database;

    function __construct()
    {
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
    function __call(string $name, array $arguments)
    {
        switch ($name) {
            case 'save':
                $builder = new QueryBuilder();
                if (!empty($arguments[0]))
                    $this->table = $arguments[0];
                if (!empty($this->table)) {
                    $builder->insert($this->fields, $this->table);
                    Core::GetInstance()->GetDatabase()->execute($builder);
                } else
                    //ERROR

                    break;
        }
    }
}
