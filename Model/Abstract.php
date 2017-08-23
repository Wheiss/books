<?php

abstract class Model_Abstract
{
    protected $_tableName;
    protected $_rowClass;

    public function clear()
    {
        $db = Db::getConnection();
        $query = "TRUNCATE TABLE " . $this->_tableName;
        if ($db->query($query)) {
            return true;
        }
    }

    public function createRow()
    {
        return $this->_fetch(array());
    }

    public function getById($id)
    {
        $db = Db::getConnection();
        $query = "SELECT * FROM {$this->_tableName} WHERE id=:id";
        $query = $db->prepare($query);
        $id = intval($id);
        $query->bindParam('id', $id);
        if (!$query->execute()) {
            return false;
        }
        $result = $query->fetchObject();
        if ($result) {
            return $this->_fetch($result);
        }
    }

    public function getByName($name)
    {
        $db = Db::getConnection();
        $query = "SELECT * FROM {$this->_tableName} WHERE name=:name";
        $query = $db->prepare($query);
        $query->bindParam('name', strval($name));
        if (!$query->execute()) {
            return false;
        }
        $result = $query->fetchObject();
        return $this->_fetch($result);

    }

    protected function _fetch($result)
    {
        if (isset($result)) {
            return new $this->_rowClass($result, $this->_tableName);
        }
    }

    protected function _fetchAll($result)
    {
        $list = array();
        if (isset($result)) {
            foreach ($result as $item) {
                $row = $this->_fetch($item);
                $list[] = $row;
            }
        }
        return $list;

    }

    public function getList()
    {
        $db = Db::getConnection();
        $query = "SELECT * FROM " . $this->_tableName;
        $result = $db->query($query);

        return $this->_fetchAll($result);
    }



    public function getRowsCount()
    {
        $db = Db::getConnection();

        $query = 'SELECT COUNT(*) FROM ' . $this->_tableName;
        return (int)$db->query($query)->fetch()[0];
    }
}