<?php
require_once(ROOT_PATH . "/app/database/db.php");
require_once(ROOT_PATH . "/app/helpers/middleware.php");
require_once(ROOT_PATH . "/app/helpers/validateUser.php");

//$table = 'users';

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
        var_dump('herelogged');
        var_dump($_SESSION);
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['message'] = 'Vous êtes connecté';
        $_SESSION['type'] = 'success';

        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/admin/dashboard.php');
        }else {
            header('location: ' . BASE_URL . '/index.php');
        }
        exit();
    }

    public function createAdmin($table, $data)
    {
        $createUser = $this->dbModel->create($table, $data);

        $_SESSION['message'] = "L'utilisateur admin a été créé.";
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    }

    public function createUser($table, $data)
    {
        $createUser = $this->dbModel->create($table, $data);
        return $createUser;
    }

    public function updateUser($table, $id, $data)
    {
        $updateUser = $this->dbModel->update($table, $id, $data);
        //return $updateUser;
        $_SESSION['message'] = "L'utilisateur a été actualisé.";
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    }

    public function deleteUser($table, $id)
    {
        $deleteUser = $this->dbModel->delete($table, $id);

        $_SESSION['message'] = 'L\'utilisateur a été effacé.';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    }
}

