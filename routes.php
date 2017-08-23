<?php

return array(
    'addBook' => array('reg_exp' => 'add',
        'rule' => '/add',
        'controller' => 'Book_Controller',
        'action' => 'addBook',
        'parameters' => array(),

    ),
    'ajaxEditBook' => array('reg_exp' => 'ajax\/book-edit\/(\d+)',
        'rule' => '/ajax/book-edit/~ID~',
        'controller' => 'Ajax_Controller',
        'action' => 'bookEdit',
        'parameters' => array('ID' => NULL),
    ),
    'books' => array('reg_exp' => '(?:(\d+)(?:\/?(\w*(?:-\w*)?))?)?',
        'rule' => '/~PAGE~/~SORT~',
        'controller' => 'Book_Controller',
        'action' => 'showBooksList',
        'parameters' => array('PAGE' => 1, 'SORT' => 'id-asc')
    ),
    'deleteBook' => array('reg_exp' => 'delete\/(\d+)',
        'rule' => '/delete/~ID~',
        'controller' => 'Book_Controller',
        'action' => 'deleteBook',
        'parameters' => array('ID' => NULL)
    ),
    'editBook' => array('reg_exp' => 'edit\/(\d+)',
        'rule' => '/edit/~ID~',
        'controller' => 'Book_Controller',
        'action' => 'editBook',
        'parameters' => array('ID' => NULL)
    ),

    'editBookSave' => array('reg_exp' => 'edit\/save',
        'rule' => '/edit/save',
        'controller' => 'Book_Controller',
        'action' => 'editBookSave',
        'parameters' => array()
    ),
    'seedAuthors' => array('reg_exp' => 'seed\/authors',
        'rule' => '/seed/authors',
        'controller' => 'Seed_Controller',
        'action' => 'authors',
        'parameters' => array()
    ),
    'seedBooks' => array('reg_exp' => 'seed\/books',
        'rule' => '/seed/books',
        'controller' => 'Seed_Controller',
        'action' => 'books',
        'parameters' => array()
    ),
    'signIn' => array('reg_exp' => 'sign_in',
        'rule' => '/sign_in',
        'controller' => 'Authorisation_Controller',
        'action' => 'signIn',
        'parameters' => array()
    ),
    'signOut' => array('reg_exp' => 'sign_out',
        'rule' => '/sign_out',
        'controller' => 'Authorisation_Controller',
        'action' => 'signOut',
        'parameters' => array()
    ),
);