    <a href="<?= Router::url('addBook') ?>">Добавить книгу</a>
    <div class="paginator"><?=render(ROOT . '/view/paginatorItem.php', array('paginator' => $paginator, 'sort' => $sort))?></div>
    <table id="books-list">
        <tr class="table-header">
            <td><a href='<?=Router::url('books',
                    array('PAGE' => $paginator->getCurrentPage(),
                          'SORT' => ($sort == 'id-asc')?
                                    'id-desc' : 'id-asc'))?>'>id</a></td>
            <td><a href='<?=Router::url('books',
                    array('PAGE' => $paginator->getCurrentPage(),
                    'SORT' => ($sort == 'author-asc')?
                              'author-desc' :'author-asc'))?>'>Автор</a></td>
            <td><a href='<?=Router::url('books',
                    array('PAGE' => $paginator->getCurrentPage(),
                          'SORT' => ($sort == 'name-asc')?
                                    'name-desc' :'name-asc'))?>'>Название</a></td>
            <td>
                <a href='<?=Router::url('books',
                    array('PAGE' => $paginator->getCurrentPage(),
                          'SORT' => ($sort == 'year-asc')?
                                     'year-desc' :'year-asc'))?>'>Год</a>
            </td>
        </tr>
        <?php $counter = 0; ?>
        <?php foreach ($books as $book) : ?>
            <?php ( ($counter % 2) == 0) ? $even = true : $even = false;
            echo render(ROOT . "/view/booksList/bookItem.php", array('book' => $book, 'even' => $even));
            $counter++; ?>
        <?php endforeach; ?>
    </table>
    <?= isset($errors['load_list_error']) ? "<p class='error'>" . $errors['load_list_error'] . "</p>" : "" ?>
    <div class="paginator"><?=render(ROOT . '/view/paginatorItem.php', array('paginator' => $paginator, 'sort' => $sort))?></div>