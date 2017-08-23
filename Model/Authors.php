<?php

class Model_Authors extends Model_Abstract
{
    protected $_tableName = 'authors';
    protected $_rowClass = 'Model_Row_Author';

    public function getByFullName($fullName)
    {

        $nameArray = explode(' ', $fullName);
        $firstName = $nameArray[0];
        $arrLength = count($nameArray);
        if ($arrLength > 2) {
            for($i = 1; $i < ($arrLength - 1); $i++){
                $nickName[] = $nameArray[$i];
            }
            $nickName = implode(' ', $nickName);
            $lastName = $nameArray[$arrLength - 1];
        } else {
            $lastName = $nameArray[1];
        }
        $db = Db::getConnection();
        $query = "SELECT * FROM {$this->_tableName} WHERE firstName=:firstName AND nickName=:nickName AND lastName=:lastName";
        $query = $db->prepare($query);
        $firstName = strval($firstName);
        $query->bindParam('firstName', $firstName);
        $nickName = isset($nickName) ? $nickName : '';
        $nickName = strval($nickName);
        $query->bindParam('nickName', $nickName);
        $lastName = strval($lastName);
        $query->bindParam('lastName', $lastName);
        if (!$query->execute()) {
            return false;
        }
        $result = $query->fetch();

        return $this->_fetch($result);
    }


}