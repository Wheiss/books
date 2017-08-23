<div class="books-block">
    <p><?=$blockName?></p>
    <table>
        <tr class="table-header">
            <td>Рейтинг</td>
            <td>Название</td>
            <td>Год</td>
        </tr>
        <?php if(isset($books)) : ?>
        <?php $counter = 0; ?>
        <?php foreach ($books as $book) : ?>
            <?php
            echo  render(ROOT . "/view/booksBlock/bookItem.php", array('book' => $book));
            $counter++; ?>
        <?php endforeach; ?>
        <?php endif;?>
    </table>
</div>