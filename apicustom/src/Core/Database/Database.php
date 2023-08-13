<?php

namespace App\Core\Database;

use PDO;

class Database
{
    protected $host;
    protected $username;
    protected $password;
    protected $dbname;
    protected PDO $pdo;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function __dectruct()
    {
        # Видалити об'єкт
        unset($this->pdo);
    }

    public function getConnectionString()
    {
        return "mysql:host={$this->host};dbname={$this->dbname}";

    }

    public function connect()
    {
        $this->pdo = new PDO($this->getConnectionString(), $this->username, $this->password);
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function execute(QueryBuilder $builder)
    {
        $sth = $this->pdo->prepare($builder->getSql());
        $params = $builder->getParams();
        /*echo("\n----params-----------\n");
        var_dump($params);
        echo("\n---------------\n");*/
        foreach ($params as $key => $value) {
            $sth->bindValue($key, $value);
        }
        /*echo("\n---------------\n");
        var_dump($sth);
        echo("\n---------------\n");*/
        $sth->execute();
        return $sth->fetchAll();
    }
}