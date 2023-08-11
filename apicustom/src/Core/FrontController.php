<?php

namespace App\Core;

use App\Core\Attributes\Route;

# Обробляє url
class FrontController
{
    public function run()
    {
        # адрес, що запитує користувач
        # /api/SomeController/метод
        $url = $_SERVER['REQUEST_URI'];
        # парсинг посилання
        $url_elements = explode('/', $url);
        $url_elements = array_slice($url_elements, 2);
        if (!empty($url_elements) && !empty($url_elements[0])) {
            # Формуємо назви
            # ucfirst() - перша літера велика
            $controller = 'App\Controllers\\' . ucfirst($url_elements[0]) . 'Controller';
            # Чи існує елемент
//            if (isset($url_elements[1])){
//                $method = $url_elements[1];
//            } else
//                $method = 'index';
            $method = !empty($url_elements[1]) ? $url_elements[1] : "index";
        } else {
            $controller = "App\Controllers\SiteController";
            $method = "index";
        }
        # Перевірка існування класу та методу
        if (class_exists($controller)) {
            $controller_object = new $controller();
            $routes = [];
            # Для Reflection API
            $reflectionClass = new \ReflectionClass($controller_object);
            $methods_list = $reflectionClass->getMethods();
            foreach ($methods_list as $reflectionMethod) {
                $attributes = $reflectionMethod->getAttributes(Route::class);
                foreach ($attributes as $attribute) {
                    if ($attribute->getName() === Route::class) {
                        /** @var Route $route */
                        $route = $attribute->newInstance();
                        $routes[$route->getPath()] = [
                            'action' => $reflectionMethod->getName(),
                            'method' => $route->getMethod()];
                    }
                }
            }
            if (!empty($routes[$method]))
                $method = $routes[$method]['action'];
            #---------------------
            if (method_exists($controller, $method)) {
                /** @var $response Response */
                $response = $controller_object->$method();
                # instanceof - перевірка не просто чи порожнє, а саме має об'єкт Response, включачи наслідування (всі похідні класи)
                if ($response instanceof Response) {
                    echo $response->getText();
                }
                /** @var $response string */
                if (gettype($response) === 'string') {
                    echo $response;
                }
            } else
                echo("Error 404!");
        } else
            echo("Error 404!");
    }
}
