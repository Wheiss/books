<?php

class Model_Users extends Model_Abstract
{
    protected $_tableName = 'users';
    protected $_rowClass = 'Model_Row_User';

    public function verify($user)
    {
        $db = Db::getConnection();
        $query = "SELECT * FROM $this->_tableName WHERE login=:login";
        $query = $db->prepare($query);
        $query->bindParam('login', $user->login);
        $query->execute();
        $result = $query->fetch();
        if (!$result) {
            return "Authentication fails!";
        }
        $passwordHash = $result['passwordHash'];
        // Непосредственно проверка пароля и возврат ошибки в случае неудачи
        if (password_verify($user->password, $passwordHash)) {
            return true;
        } else {
            return "Authentication fails!";
        }
    }
}