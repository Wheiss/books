<?php
$booksModel = new Model_Books;
$randomBooks = $booksModel->getRandomList(5, 20);
$blockName = '5 случаных книг:';
echo render(ROOT . '/view/booksBlock/booksList.php', array('books' => $randomBooks, 'blockName' => $blockName));

