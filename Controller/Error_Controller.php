<?php

class Error_Controller extends Controller
{
    private $_errorMessage = NULL;
    private static $_logFile = ROOT . '/logs/app.log';

    public function __construct($exception)
    {
        $this->_errorMessage = $exception;
    }

    public function errorAction()
    {
        header("HTTP/1.0 404 Not Found");
        file_put_contents(self::$_logFile,
            "\n" . date('d M y G:i:s') . ' : ' . $this->_errorMessage,
            FILE_APPEND);
        
        return true;
    }
}
