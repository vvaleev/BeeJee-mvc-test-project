<?php

use System\Sessions\Session;
use System\Sql\DataBase;

class AuthModel extends System\Model
{
    public function __construct()
    {
        parent::__construct();

        Session::start();
        DataBase::getInstance();
    }

    public function isAuth()
    {
        if (!empty(Session::get('auth_data'))) {
            return true;
        }

        return false;
    }

    public function auth($login, $password)
    {
        $data = DataBase::query('
            SELECT
              id, first_name, last_name, role
            FROM
              users
            WHERE
                login = :login AND password = :password
        ',
        true,
        [
            'login' => $login,
            'password' => $password,
        ]
        );

        if (!empty($data->row)) {
            Session::set('auth_data', $data->row);

            return true;
        }

        return false;
    }

    public function getData($param = [])
    {
        return Session::get('auth_data');
    }

    public function logout()
    {
        Session::remove('auth_data');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
