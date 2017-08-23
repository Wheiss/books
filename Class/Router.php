<?php

class Router
{
    private $_controllerName = NULL;
    private $_actionName = NULL;
    private $_params = NULL;

    /*
     * Метод принимает url, и записывает контроллер, экшн и [параметры]
     */
    public function __construct($uri)
    {
        $this->parse($uri);
    }

    public function parse($uri)
    {
        $routes = include_once ROOT . '/routes.php';
        foreach ($routes as $route) {
            $reg_exp = "/^" . $route['reg_exp'] . "$/";
            if (!preg_match($reg_exp, $uri, $matches)) {
                continue;
            }
            $this->_controllerName = $route['controller'];
            $this->_actionName = $route['action'] . 'Action';
            //  Сдвиг $matches для пропуска [0] где хранится все совпадение
            array_shift($matches);
            //  Ассоциативный массив параметров, которые мы отправим в функцию
            foreach ($route['parameters'] as $param => $defaultVal) {
                $this->_params[$param] = array_shift($matches);
            }
            return;
        }
        //  В этой точке мы прошлись по всем роутам и кидаем исключение
        throw new Exception('404 Not Found');
    }

    /*
     * Метод возвращает имя контроллера
     */
    public function getControllerName()
    {
        return $this->_controllerName;
    }

    /*
     * Метод возвращает имя экшена
     */
    public function getActionName()
    {
        return $this->_actionName;
    }

    /*
     * Метод возвращает параметры, если ои заданы
     */
    public function getParameters()
    {
        return $this->_params;
    }
    public static function url($route, array $parameters = array())
    {
        $routes = include ROOT . '/routes.php';
        if (!isset($routes[$route])) {
            throw new Exception('This route does not exist');
        }
        $route = $routes[$route];
        $url = $route['rule'];
        $route_parameters = $route['parameters'];

        $urlParams = array_replace($route_parameters, $parameters);

        foreach ($urlParams as $param => $value) {
            if(!isset($value)) {
                throw new Exception('URL Parameter missing.' );
            }
            $url = str_replace('~' . $param . '~', $value, $url);
        }

        return $url;

    }
}