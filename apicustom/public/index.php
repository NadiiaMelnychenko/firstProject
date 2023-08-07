<?php
global $CoreParams;
# Підключення файлів
require_once ('../config/config.php');
#include () - якщо файлу не існує просто не підключить
#require - якщо файлу не існує - помилка
#include_once() - одноразове підключення з once

# spl_autoload - примусово запускає підключення певного класу
# якщо клас ще не оголошено, запускається spl_autoload_register
spl_autoload_register(function ($className){
    $path = "../src/{$className}.php";
    if(file_exists($path)){
        require_once ($path);
    }

});
$database = new Database(
    $CoreParams ['Database']['Host'],
    $CoreParams ['Database']['Username'],
    $CoreParams ['Database']['Password'],
    $CoreParams ['Database']['Database']
);
$database->connect();


$query = new QueryBuilder();
$query->select(["title, text"])
    ->from("news")
    ->where(['id'=>5]);
#$query->AndWhere
$rows = $database->execute($query);
var_dump($rows);

//$front_controller = new FrontController();
//$front_controller->run();





