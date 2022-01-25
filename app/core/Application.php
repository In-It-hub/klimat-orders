<?php 

class Application {
    
    
    protected $controller = 'Home'; //Контроллер
    protected $action = 'index'; //Метод 
    protected $params = []; //Параметры метода

    function __construct() {
        $this->prepareURL();//Вызываем метод prepareURL описаный ниже
        
        if(file_exists(CONTROLLER . $this->controller . '.php')){
            
            $this->controller = new $this->controller;
            //Проверяем существует лит метод в классе
            if (method_exists($this->controller, $this->action)){
                //Вызывает callback-функцию с массивом параметров
                call_user_func_array([$this->controller, $this->action], $this->params);
            }
        }

    }

    protected function prepareURL() {
        //Удаляем с начала и конца строки $_SERVER['REQUEST_URI'] знак /
        $request = trim($_SERVER['REQUEST_URI'], '/');
        //Если переменная $request не пустая строка, то
        if (!empty($request)) {
            //Разобем строку $request в масив строк, разделителем служит знака /
            $url = explode('/', $request);
            //если элемент масива $url[0] не равняеться NULL тогда $controller = значение єлемента масива $url[0]
            if (isset($url[0])) {
                if ($url[0] == 'telegram'){
                    $this->controller = 'telegram';
                }
                elseif (!isset($_SESSION['user']) && !isset($_SESSION['token'])) {
                    $this->controller = 'Login';
                }
                else {
                    $this->controller = $url[0];
                }
            } 
            //Если элемент масива $url[1] не равняеться NULL тогда $action = значение єлемента масива $url[1]
            if (isset($url[1])) {
                $this->action = $url[1];
            } else {
                $this->action = 'index';
            }
            
            //Удаляем элементы массива $url[0], $url[1]
            unset($url[0], $url[1]);
            /* Если после удаления $url[0], $url[1] $url не равняеться пустой строкой то заново индексируем масив $url
               и присваиваем $this->params значение $url. Иначе $this->params = []*/
            $this->params = !empty($url) ? array_values($url) : [];
        }
        else {
            if (!isset($_SESSION['user'])) {
                $this->controller = 'Login';
            }
        }

    }
}
