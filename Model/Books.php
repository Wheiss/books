<?php

class Model_Books extends Model_Abstract
{
    protected $_tableName = 'books';
    protected $_rowClass = 'Model_Row_Book';
    public $availableSorts = array('id' => array('field' => 'id', 'joinTable' => false),
        'authorname' => array('field' => 'authorId', 'joinTable' => 'authors', 'joinField' => 'id', 'joinOrderField' => array('firstName', 'lastName')),
        'name' => array('field' => 'name', 'joinTable' => false),
        'year' => array('field' => 'year', 'joinTable' => false)
    );

    public function getRandomList($rowsAmount, $maxRequests)
    {

        $db = Db::getConnection();

        $query = 'SELECT id FROM ' . $this->_tableName . ' ORDER BY id DESC LIMIT 1';
        $maxId = (int)$db->query($query)->fetch()['id'];

        $query = 'SELECT id FROM ' . $this->_tableName . ' WHERE id=:id';
        $query = $db->prepare($query);

        $booksModel = new Model_Books();
        $randomBooks = array();

        for ($num = 0; $num < $maxRequests; $num++) {
            if ($rowsAmount < 1) {
                break;
            }
            $rand = rand(0, $maxId);
            $query->bindParam('id', $rand);
            $query->execute();
            $result = $query->fetch()['id'];
            if($book = $booksModel->getById($result)) {
                $randomBooks[] = $book;
                $rowsAmount--;
            }
        }
        return $randomBooks;
    }

    public function getTopList()
    {
        $db = Db::getConnection();
        $query = 'SELECT * FROM ' . $this->_tableName . ' ORDER BY rating DESC, year DESC LIMIT 5';

        $result = $db->query($query);
        return $this->_fetchAll($result);
    }
    public function getListPaginator($page, $elementCount, $sort = 'id', $sortAttribute = 'asc')
    {
        /* Sort attribute*/
        if (preg_match('/(\w+)(?:-(\w+))?/', $sort, $matches)) {
            $sortAttribute = $matches[2];
            $sortName = $matches[1];
        } else {
            $sortName = 'id';
        }
        if (!array_key_exists($sortName, $this->availableSorts)) {
            $sort = $this->availableSorts['id'];
            $sortAttribute = 'asc';
        } else {
            $sort = $this->availableSorts[$sortName];
        }

        $offset = ($page - 1) * $elementCount;
        $db = Db::getConnection();

        if($sort['joinTable'] != false) {
            if(is_array($sort['joinOrderField'])) {
                $order = '';
                foreach ($sort['joinOrderField'] as $orderField){
                    $order .= $orderField . ' ' . strtoupper($sortAttribute) . ',';
                }
                $order = trim($order, ',');
            } else {
                $order = $sort['joinOrderField'] . ' ' . strtoupper($sortAttribute);
            }
            $query = 'SELECT ' . $this->_tableName . '.* FROM '
                . $this->_tableName . ' JOIN ' . $sort['joinTable'] . ' ON ' . $this->_tableName . '.' . $sort['field']
                . '=' . $sort['joinTable'] . '.' . $sort['joinField']
                . ' ORDER BY ' . $order
                . ' LIMIT ' . $elementCount . ' OFFSET ' . $offset;
        } else {
            $query = 'SELECT ' . $this->_tableName . '.* FROM '
                . $this->_tableName . ' ORDER BY ' . $sort['field'] . ' ' . strtoupper($sortAttribute)
                . ' LIMIT ' . $elementCount . ' OFFSET ' . $offset;
        }
        $result = $db->query($query);
        $items = $this->_fetchAll($result);
        /* Вычисление кол-ва страниц, у нас нет никаких выборок, которые ограничивают кол-во элементов*/
        $countQuery = 'SELECT COUNT(*) FROM ' . $this->_tableName;
        $countResult = $db->query($countQuery);

        $itemCount = $countResult->fetch()[0]/$elementCount;
        $paginator = new Paginator();
        $paginator->setItems($items);
        $paginator->setItemsCount($itemCount);
        $paginator->setCurrentPage($page);
        $paginator->setPageSize($elementCount);
        $paginator->generatePages();

        return $paginator;
    }
}