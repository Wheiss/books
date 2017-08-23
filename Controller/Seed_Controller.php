<?php

class Seed_Controller extends Controller
{
    public function authorsAction()
    {
        $authorsModel = new Model_Authors();
        $authorsModel->clear();
        $authors = $authorsModel->getList();

        $authorsFirstNames = array(
            'Николай',
            'Эдуард',
            'Виктор',
            'Лев',
            'Корней',
            'Борис',
            'Александр',
            'Владимир',
            'Антуан',
            'Эрнест',
            );
        $authorsLastNames = array('Гоголь',
            'Успенский',
            'Пелевин',
            'Толстой',
            'Чуковский',
            'Пастернак',
            'Пушкин',
            'Маяковский',
            'де Сент-Экзюпери',
            'Хемингуэй',
        );
        $authorsNickNames = array('Жгу',
            'Чебурашка только мой!',
            'Давай расширимся',
            'Читай меня полностью',
            'Прет не по-детски',
            'Обнять и плакать',
            'Ваше все',
            'Мой.Псевдоним.Неброский',
            'Ну нарисуй барашка',
            'Не пишу трезвым',
        );
        $globalCounter = 0;
        foreach ($authorsFirstNames as $firstName) {
            $randomNickNames = array_rand($authorsNickNames, 3);
            shuffle($randomNickNames);
            $randomKeys = array_rand($authorsLastNames, 3);

            $counter = 0;
            foreach ($authorsLastNames as $lastName) {
                $authors[$globalCounter] = $authorsModel->createRow();
                if (in_array($counter, $randomKeys, true)) {
                    $authors[$globalCounter]->setParams(array('firstName' => $firstName,
                        'lastName' => $lastName, 'nickName' => $authorsNickNames[array_shift($randomNickNames)]));
                } else {
                    $authors[$globalCounter]->setParams(array('firstName' => $firstName,
                        'lastName' => $lastName));
                }
                $authors[$globalCounter]->save();
                $globalCounter++;
                $counter++;
            }
        }
        Application::getInstance()->setTemplate('empty');
    }

    public function booksAction()
    {
        set_time_limit(2400);
        ini_set('session.gc_maxlifetime', 2400);
        Application::getInstance()->setTemplate('empty');
        $bookNames = file(ROOT . '/uploads/books.txt');
        $bookModel = new Model_Books();
        $bookModel->clear();
        $authorsModel = new Model_Authors();
        $authors = $authorsModel->getList();
        foreach ($authors as $author) {
            foreach ($bookNames as $bookName) {
                $now = new DateTime();
                $bookObject = $bookModel->createRow();
                $bookObject->setParams(array('name' => $bookName,
                    'authorId' => $author->id,
                    'year' => rand(1724, 2017),
                    'rating' => rand(0, 10),
                    'created' => $now->format('Y-m-d H:i:s')));
                $bookObject->save();
            }
        }
    }
}