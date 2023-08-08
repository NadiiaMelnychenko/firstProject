<?php

namespace App\Core\Database;
class QueryBuilder
{
    protected $params;
    protected $type;
    protected $fields;
    protected $table;
    protected $joinTable;
    protected $joinType;
    protected $on;
    protected $tableCol;
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

    public function insert($tableCol, $fields)
    {
        $this->type = "insert";
        $fields_string = $fields;
        $tableCol_string = $tableCol;
        if (is_array($fields))
            $fields_string = implode("', '", $fields);
        if (is_array($tableCol))
            $tableCol_string = implode(", ", $tableCol);
        $this->fields = "('" . $fields_string . "')";
        $this->tableCol = "(" . $tableCol_string . ")";
        return $this;
    }

    public function update($tableCol, $fields)
    {
        $this->type = "update";
        if (is_array($tableCol)) {
            foreach ($tableCol as $k => $v) {
                $res[] = "$v='$fields[$k]'";
            }
        } else
            $res[] = "$tableCol='$fields'";
        $res_string = $res;
        if (is_array($res))
            $res_string = implode(", ", $res);
        $this->fields = $res_string;
        return $this;
    }

    public function delete()
    {
        $this->type = "delete";
        return $this;
    }

    public function join($how, $table, $on)
    {
        $this->joinType = strtoupper($how);
        $this->joinTable = $table;
        $on_string = $on;
        if (is_array($on))
            $on_string = implode(", ", $on);
        $this->on = $on_string;
        return $this;
    }

    public function fromToTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getSql()
    {
        switch ($this->type) {
            case 'select':
                $sql = "SELECT {$this->fields} FROM {$this->table}";
                if (!empty($this->joinTable))
                    $sql .= " {$this->joinType} JOIN {$this->joinTable} ON {$this->on}";
                if (!empty($this->where))
                    $sql .= " WHERE {$this->where}";
                return $sql;
                break;
            //SELECT news.title, news.text, comments.text FROM `news` INNER JOIN comments ON news.id=comments.news_id WHERE news.id=9
            case 'insert':
                return "INSERT INTO {$this->table} {$this->tableCol} VALUES {$this->fields}";
                break;
            case 'update':
                $sql = "UPDATE {$this->table} SET {$this->fields}";
                if (!empty($this->where))
                    $sql .= " WHERE {$this->where}";
                return $sql;
                break;
            case 'delete':
                $sql = "DELETE FROM {$this->table}";
                if (!empty($this->where))
                    $sql .= " WHERE {$this->where}";
                return $sql;
                break;
        }
    }

    public function where($where): QueryBuilder
    {
        $where_parts = [];
        foreach ($where as $key => $value) {
            //array_push($where_parts);
            if (strpos($key, '.')) {
                $dkey = str_replace(".", "", $key);
                $this->params[$dkey] = $value;
                $where_parts [] = "{$key} = :{$dkey}";
            } else {
                $this->params[$key] = $value;
                $where_parts [] = "{$key} = :{$key}";
            }
        }
        var_dump($this->params);
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