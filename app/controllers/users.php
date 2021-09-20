<?php
require_once(ROOT_PATH . "../../app/database/db.php");
require_once(ROOT_PATH . "../../app/helpers/middleware.php");
require_once(ROOT_PATH . "../../app/helpers/validateUser.php");

class UsersController
{
    private $dbModel;

    function __construct()
    {
      $this->dbModel = new DbModel();
    }

    public function selectAllUsers($table)
    {
        $adminUsers = $this->dbModel->selectAll($table);
        return $adminUsers;
    }

    public function selectOneUser($table, $data)
    {
        $user = $this->dbModel->selectOne($table, $data);
        return $user;
    }

    public function loggedUser($user)
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['message'] = 'Vous êtes connecté';
        $_SESSION['type'] = 'success';


        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/views/admin/dashboard.php?dashboard');
        }else {
            header('location: ' . BASE_URL . '');
        }
        exit();
    }
}

