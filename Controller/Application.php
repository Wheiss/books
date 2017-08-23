<?php

class Application
{
    private static $_instance;
    private $_template = 'index';
    private $_startTime = NULL;

    private function __construct()
    {
        $this->_startTime = microtime(true);
    }

    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new Application();
        }
        return self::$_instance;
    }

    public function run()
    {
        try {
            if(!isset($_SESSION['sessionStartTime'])) {
                $_SESSION['sessionStartTime'] = new DateTime();
            }
            $uri = getURI();
            $router = new Router($uri);
            $controllerName = $router->getControllerName();
            $actionName = $router->getActionName();
            $parameters = $router->getParameters();

            @$_REQUEST = array_merge($_REQUEST, $parameters);
            //  Проверка аутентификации
            if (empty($_SESSION['user'])) {
                $controllerName = 'Authorisation_Controller';
                $actionName = 'signInAction';
            }
            // Подключаем файл класса-контроллера
            $controllerFile = ROOT . '/Controller/' . $controllerName . '.php';
            if (!file_exists($controllerFile)) {
                throw new Exception("Controller $controllerName does not exist.");
            }
            include_once($controllerFile);
            // Создаем объект, вызываем метод (action)
            $controllerObject = new $controllerName;
            if (!method_exists($controllerObject, $actionName)) {
                throw new Exception("Action $actionName in Controller $controllerName does not exist");
            }

            // Вызов метода $actionName класса $ControllerName
            $content = call_user_func(array($controllerObject, $actionName));

            $finalOutput = render(ROOT . "/layout/$this->_template/index.php",  array('content' => $content));
            echo $finalOutput;
            return;
        } catch (Exception $exception) {
            $errorObject = new Error_Controller($exception);
            $errorObject->errorAction();
        }
    }

    public function setTemplate($templateName)
    {
        $this->_template = $templateName;
    }
    public function getExecutionTime()
    {
        $executionTime = (microtime(true) - $this->_startTime);
        return $executionTime;
    }
}