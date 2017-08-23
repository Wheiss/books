<?php
$booksModel = new Model_Books;
$topBooks = $booksModel->getTopList();
$blockName = 'Топ книг:';
echo render(ROOT . '/view/booksBlock/booksList.php', array('books' => $topBooks, 'blockName' => $blockName));