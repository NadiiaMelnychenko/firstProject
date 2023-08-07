<?php

class QueryBuilder
{
    protected $params;
    protected $type;
    protected $fields;
    protected $table;
    protected $where;

    public function __construct()
    {
        $this->params = [];
    }

    public function select($fields = "*")
    {
        $this->type = "select";
        $fields_string = $fields;
        if (is_array($fields))
            $fields_string = implode(", ", $fields);
        $this->fields = $fields_string;
        return $this;
    }

    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getSql()
    {
        switch ($this->type) {
            case 'select':
                $sql = "SELECT {$this->fields} FROM {$this->table}";
                if (!empty($this->where))
                    $sql .= " WHERE {$this->where}";
                return $sql;
                break;
        }
    }

    public function where($where): QueryBuilder
    {
        //is_a - асоціативний масив чи ні
//        if(is_a($where)){
//
//        }
        $where_parts = [];
        foreach ($where as $key => $value) {
            //array_push($where_parts);
            #додаємо елементи в кінець масиву
            $where_parts [] = "{$key} = :{$key}";
            $this->params[$key] = $value;
        }
        $this->where = implode(' AND ', $where_parts);
        return $this;
    }
    public function getParams(): array
    {
        return $this->params;
    }

//$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms", "cms-user", "123456");
//$sth = $pdo->prepare("SELECT * FROM news WHERE id=?");
//$sth ->execute([4]); - 4 замість ?

//$sth = $pdo->prepare("SELECT * FROM news WHERE id=:id");
//# bindValue("id",4) - прив'язує до параметру значення
//$sth->bindValue("id",4);
//$sth ->execute();
//$rows = $sth->fetchAll();
}

//alt+ctrl+l