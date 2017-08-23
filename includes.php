<?php
    $paths = array(
        '/Class/Router',
        '/Class/Config',
        '/Class/Db',
        '/Class/Paginator',
        '/Model/Abstract',
        '/Model/Books',
        '/Model/Authors',
        '/Model/Users',
        '/Model/Row/Abstract',
        '/Model/Row/Book',
        '/Model/Row/Author',
        '/Model/Row/User',
        '/Controller/Controller',
        '/Controller/Application',
        '/Controller/Authorisation_Controller',
        '/Controller/Book_Controller',
        '/Controller/Seed_Controller',
        '/Controller/Error_Controller',
        '/functions',
    );
    foreach ($paths as $path) {
        include_once ROOT . $path . '.php';
    }