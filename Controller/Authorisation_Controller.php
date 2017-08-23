<?php

/**
 * Класс для регистрации, авторизации пользователей
 */
class Authorisation_Controller extends Controller
{
    private $_authorisationErrors = array();

    /*
     * Метод для авторизации пользователей.
     * На вход получаем логин, пароль.
     * После успешной авторизации сохраняем ее в сессию
     */
    public function signInAction()
    {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . Router::url('index'));
            die;
        }
        //  В случае получения логина из $_POST проведем авторизацию
        if (!empty($_POST['login'])) {
            $userModel = new Model_Users();
            $userObject = $userModel->createRow();
            $userObject->setParams(array('login' => $_POST['login'],
                    'password' => isset($_POST['password']) ? $_POST['password'] : '')
            );
            $result = $userModel->verify($userObject);
            if ($result !== true) {
                $this->_authorisationErrors['authError'] = $result;
            } else {
                $_SESSION['user'] = $_POST['login'];
                header('Location: ' . Router::url('books'));
                die;
            }
        }

        Application::getInstance()->setTemplate('empty');

        return render(ROOT . '/view/authorisation/authForm.php', array(
            'authorisationErrors' => $this->_authorisationErrors,
        ));
    }

    /*
     * Метод для выхода, обнуляет сессию
     */
    public function signOutAction()
    {
        //	Очищаем данные сессии
        $_SESSION['user'] = NULL;
        header('Location: ' . Router::url('signIn'));
        die;
    }
}