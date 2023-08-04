<?php
# Обробляє url
class FrontController{
    public function run(){
        # адрес, що запитує користувач
        # /api/SomeController/метод
        $url = $_SERVER['REQUEST_URI'];
        # парсинг посилання
        $url_elements = explode('/', $url);
        $url_elements = array_slice($url_elements, 2);
        if (!empty($url_elements) && !empty($url_elements[0])){
            # Формуємо назви
            # ucfirst() - перша літера велика
            $controller = ucfirst($url_elements[0]) . 'Controller';
            # Чи існує елемент
//            if (isset($url_elements[1])){
//                $method = $url_elements[1];
//            } else
//                $method = 'index';
            $method = !empty($url_elements[1]) ? $url_elements[1] : "index";
        }
        else {
            $controller = "SiteController";
            $method = "index";
        }
        # Перевірка існування класу та методу
        if (class_exists($controller)){
            $controller_object = new $controller();
            if(method_exists($controller, $method)){
                /** @var $response Response */
                $response = $controller_object->$method();
                # instanceof - перевірка не просто чи порожнє, а саме має об'єкт Response, включачи наслідування (всі похідні класи)
                if ($response instanceof Response){
                    echo $response->getText();
                }
            }
            else
                echo ("Error 404!");
        }else
            echo ("Error 404!");
    }
}
