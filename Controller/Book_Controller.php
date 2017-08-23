<?php

class Book_Controller extends Controller
{
    private $_bookErrors = array();

    public function showBooksListAction()
    {
        $page = isset($_REQUEST['PAGE']) ? $_REQUEST['PAGE'] : 1;
        $sort = isset($_REQUEST['SORT']) ? $_REQUEST['SORT'] : NULL;
        $this->_bookErrors = array('load_list_error' => '');

        $booksModel = new Model_Books;
        $booksPaginator = $booksModel->getListPaginator($page, 50, $sort);

        if ($booksPaginator->getItems() == false) {
            $this->_bookErrors['load_list_error'] = 'Не удалось загрузить список книг';
        }

        Application::getInstance()->setTemplate('indexWithRightColumn');

        return render(ROOT . '/view/booksList/booksList.php',
            array('books' => $booksPaginator->getItems(),
                'paginator' => $booksPaginator,
                'sort' => $sort,
                'errors' => $this->_bookErrors));
    }

    public function addBookAction()
    {
        $book = NULL;
        if (!empty($_POST)) {
            if (!empty($_POST['book_name']) AND !empty($_POST['author'])) {


                //	Если получаем автора книги:
                $authorModel = new Model_Authors();
                $authorObject = $authorModel->getByFullName($_POST['author']);
                if ($authorObject->id == NULL) {
                    // ошибка подмены данных автора
                    $this->_bookErrors['wrong_author'] = 'Некорректно задан автор';
                }
                $bookModel = new Model_Books();
                $bookObject = $bookModel->createRow();
                $now = new DateTime();

                $bookObject->setParams(array('name' => $_POST['book_name'],
                    'authorId' => $authorObject->id,
                    'year' => isset($_POST['year']) ? $_POST['year'] : NULL,
                    'created' => $now->format('Y-m-d H:i:s'),
                ));
                //	Добавляем книгу
                if ($bookObject->save()) {
                    header('Location: ' . Router::url('books'));
                    die;
                }
                // В случае неудачи -> ошибка записи в БД
                $this->_bookErrors['DB_error'] = 'Не удалось добавить запись в базу данных';

            } elseif (empty($_POST['book_name'])) {
                $this->_bookErrors['empty_book_name'] = 'Не указано название книги';
            } elseif (empty($_POST['author'])) {
                $this->_bookErrors['empty_author'] = 'Не указан автор';
            }
        }

        $authorsModel = new Model_Authors();
        $authorsArray = $authorsModel->getList();
        $action = 'addBook';
        $buttonActionText = 'Добавить';    // Задаем текст кнопки сабмита

        return render(ROOT . '/view/bookForm.php', array('book' => $book,
            'authorsArray' => $authorsArray,
            'action' => $action,
            'buttonActionText' => $buttonActionText,
            'errors' => $this->_bookErrors));
    }

    public function deleteBookAction()
    {
        $id = $_REQUEST['ID'];
        //	Удаляем из БД книгу с соответствующим id
        $bookModel = new Model_Books();
        $bookObject = $bookModel->getById($id);
        if($bookObject->delete()){
            header('Location: ' . Router::url('books'));
            die;
        }
    }

    public function editBookAction()
    {
        $id = $_REQUEST['ID'];
        $this->_bookErrors;

        if (empty($id)) {
            $this->_bookErrors['no_id'] = 'Ошибка, не получен id книги';

            $output = $this->_viewEditForm();

            return $output;
        }

        $booksModel = new Model_Books();
        if (!$book = $booksModel->getById($id)) {
            throw new Exception('Not existing id');
        }

        return $this->_viewEditForm($book);
    }

    public function editBookSaveAction()
    {
        $this->_bookErrors;
        //	Проверка заполненности полей
        if (!empty($_POST['id']) AND !empty($_POST['book_name']) AND !empty($_POST['author'])) {
            //	Проверка валидности id автора
            $authorModel = new Model_Authors();
            if (!$authorObject = $authorModel->getByFullName($_POST['author'])) {
                throw new Exception('Incorrect authorId');
            }
            $bookModel = new Model_Books();
            $bookObject = $bookModel->getById($_POST['id']);
            $now = new DateTime();
            $bookObject->setParams(array('name' => $_POST['book_name'],
                'authorId' => $authorObject->id,
                'year' => isset($_POST['year']) ? $_POST['year'] : NULL,
                'created' => $now->format('Y-m-d H:i:s'),
            ));
            $result = $bookObject->save();
            //	Запись в базу данных и проверка, прошла ли она. Метод возвращает true в случае успеха.
            if ($result) {
                header('Location: ' . Router::url('books'));
                die;
            } else {
                $this->_bookErrors['DB_error'] = 'Не удалось добавить запись в базу данных';
            }

        }
        if (!empty($_POST['id'])) {
            $bookModel = new Model_Books();
            $bookObject = $bookModel->getById($_POST['id']);
        } else {
            $this->_bookErrors['no_id'] = 'Ошибка, не получен id книги';
        }

        $output = $this->_viewEditForm($bookObject);

        return $output;
    }

    private function _viewEditForm($book = NULL)
    {
        $action = 'editBookSave';
        $buttonActionText = 'Сохранить';    // Задаем текст кнопки сабмита
        $authorsModel = new Model_Authors();
        $authorsArray = $authorsModel->getList();
        $output = render(ROOT . '/view/bookForm.php', array('book' => $book,
            'authorsArray' => $authorsArray,
            'action' => $action,
            'buttonActionText' => $buttonActionText,
            'errors' => $this->_bookErrors,
        ));

        return $output;
    }
}