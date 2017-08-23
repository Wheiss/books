<?php

class Model_Row_Book extends Model_Row_Abstract
{
    public function getAuthor()
    {
        $authorModel = new Model_Authors();
        $author = $authorModel->getById($this->authorId);
        return $author;
    }
}