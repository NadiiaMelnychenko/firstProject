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

/*#select
$query = new QueryBuilder();
$query->select(["title, text"])
    ->fromToTable("news")
    ->where(['id'=>10]);
$rows = $database->execute($query);
var_dump($rows);*/


/*  #insert
$query = new QueryBuilder();
date_default_timezone_set('Europe/Kiev');
$date = date("Y-m-d H:i:s");
$query->insert(['title','text','date'],['newTitle22', 'newText22',$date])
    ->fromToTable('news');
var_dump($query);
$rows = $database->execute($query);
*/

/*  #update
$query = new QueryBuilder();
$query->update(['title','text'],['mainTi','mainText&'])
    ->fromToTable('news')
    ->where(['title'=>'mainTitle!']);
var_dump($query);
$rows = $database->execute($query);*/
/*
  #delete
$query = new QueryBuilder();
$query->delete()
    ->fromToTable("news")
    ->where(['title'=>'wsad']);
$rows = $database->execute($query);
var_dump($rows);*/

/*#select join
$query = new QueryBuilder();
$query->select(["news.title, news.text, comments.text"])
    ->fromToTable("news")
    ->join('left','comments','news.id=comments.news_id')
    ->where(['news.id'=>9]);
$rows = $database->execute($query);
var_dump($rows);*/

$front_controller = new FrontController();
$front_controller->run();





