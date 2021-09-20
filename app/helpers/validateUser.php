<?php
require_once(ROOT_PATH . "../../app/database/db.php");

class ValidateUser
{
    private $selectOne;

    public function validateLogin($user) 
    {
        $errors = array();

        if (empty($user['username'])) {
            array_push($errors, 'Un nom d\'utilisateur est requis.');
        }

        if (empty($user['password'])) {
            array_push($errors, 'Un mot de passe est requis.');
        }
        return $errors;
    }
}
