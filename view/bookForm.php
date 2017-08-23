<center>
    <?php $book ? $created = new DateTime($book->created) : NULL ?>
    <?= $book ? "Книга №"
        . $book->id
        . " от " . $created->format('j')
        . " " . convertMonth($created)
        . " " . $created->format('Y') . " года"
        : '' ?>
    <form action='<?= Router::url($action) ?>' method='post' id='bookForm'>
        <?= (isset($errors['no_id'])) ? "<p class='error'>" . $errors['no_id'] . "</p>" : '' ?>
        <?= (isset($errors['DB_error'])) ? "<p class='error'>" . $errors['DB_error'] . "</p>" : '' ?>
        <p>Название книги</p>
        <input type='text' name='book_name' value='<?= $book ? $book->name : '' ?>'>
        <?= (isset($errors['empty_book_name'])) ? "<p class='error'>" . $errors['empty_book_name'] . "</p>" : ''; ?>
        <p>Автор</p>
        <select name='author' form='bookForm'>
            <?php foreach ($authorsArray as $author) : ?>
                <?php if ($book && ($book->authorId == $author->id)) : ?>
                    <?= "<option selected=selected>" . $author->getFullName() . "</option>" ?>
                <?php else: ?>
                    <?= "<option>" . $author->getFullName() . "</option>" ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <?= (isset($errors['wrong_author'])) ? "<p class='error'>" . $errors['wrong_author'] . "</p>" : '' ?>
        <?= (isset($errors['empty_author'])) ? "<p class='error'>" . $errors['empty_author'] . "</p>" : '' ?>
        <p>Год</p>
        <input type='text' name='year' value='<?= $book ? $book->year : '' ?>'>
        <?= (isset($errors['year'])) ? "<p class='error'>" . $errors['empty_year'] . "</p>" : '' ?>
        <?= $book ? "<input type='hidden' name='id' value='" . $book->id . "'>" : NULL ?>
        <input type='submit' value='<?= $buttonActionText ?>' id='add-btn'>
    </form>
    <a href="<?= Router::url('books', array()) ?>">К списку книг</a>
</center>