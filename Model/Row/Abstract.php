<?php

/**
 *
 */
class Model_Row_Abstract
{
    protected $_tableName;

    public function __construct($values, $tableName)
    {
        $this->_tableName = $tableName;
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    // Сохранение из свойств!!!
    public function save()
    {
        $values = get_object_vars($this);
        $db = Db::getConnection();

        $newRow = false;    // boolean
        unset($values['_tableName']);
        $oldValues = $values;

        if (!isset($values['id'])) {
            $newRow = true;
        } else {
            unset($values['id']);
        }

        $queryFields = array();

        foreach ($values as $field => $value) {
            if ($newRow) {
                array_push($queryFields, $field);
            } else {
                array_push($queryFields, $field . '=:' . $field);
            }
        }

        if ($newRow) {
            $query = 'INSERT INTO ' . $this->_tableName . ' (' . implode(',', $queryFields) . ') VALUES (:' . implode(',:', $queryFields) . ')';
        } else {
            $query = 'UPDATE ' . $this->_tableName . ' SET ' . implode(',', $queryFields) . ' WHERE id=:id';
        }
        $query = $db->prepare($query);

        if ($query->execute($oldValues)) {
            if ($newRow) {
                $this->id = $db->lastInsertId();
            }
            return true;
        }
    }

    public function setParams(array $values)
    {
        foreach ($values as $name => $value) {
            $this->$name = $value;
        }
    }

    public function delete()
    {
        $db = Db::getConnection();
        $query = "DELETE FROM " . $this->_tableName . " WHERE id=:id";
        $query = $db->prepare($query);
        $query->bindParam('id', $this->id);
        if ($query->execute()) {
            return true;
        }
    }
}