<?php

class Ajax_Controller
{
    public function bookEditAction()
    {
        Application::getInstance()->setTemplate('empty');
        $json = json_decode(file_get_contents("php://input"));
        if(!empty($_REQUEST['ID']) AND !empty($json->name) AND !empty($json->author)) {

            //	Проверка валидности id автора
            $authorModel = new Model_Authors();
            if (!$authorObject = $authorModel->getByFullName($json->author)) {
                throw new Exception('Incorrect authorId');
            }
            $bookModel = new Model_Books();
            $bookObject = $bookModel->getById($_REQUEST['ID']);
            $now = new DateTime();
            $bookObject->setParams(array('name' => $json->name,
                'authorId' => $authorObject->id,
                'year' => isset($json->year) ? $json->year : NULL,
                'created' => $now->format('Y-m-d H:i:s'),
            ));
            $result = $bookObject->save();
            //	Запись в базу данных и проверка, прошла ли она. Метод возвращает true в случае успеха.
            if ($result) {
                header("Content-type:application/json;charset=utf-");
                $bookJSON = ['id' => $bookObject->id,
                    'name' => $bookObject->name,
                    'author' => $bookObject->getAuthor()->getFullName(),
                    'year' => $bookObject->year];
                echo json_encode($bookJSON);
                die;
            }
        }
        http_response_code(400);
        die;
    }
}