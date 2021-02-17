<?php

class AuthController extends System\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __default()
    {
        $this->view->render('404');
    }

    public function showAction()
    {
        $this->view->render('auth.widget', $this->model->getData());
    }

    public function loginAction($param)
    {
        if ($this->model->isAuth()) {
            header('Location: /');
            die();
        }

        if ($param === 'form') {
            $this->view->render('header');
            $this->view->render('auth.form');
            $this->view->render('footer');

            return null;
        }

        if (
            !empty($_POST['login']) && !empty($_POST['password'])
            && $this->model->auth($_POST['login'], $_POST['password'])
        ) {
            return ['result' => true];
        }

        return ['result' => false];
    }

    public function logoutAction()
    {
        $this->model->logout();

        header('Location: /auth/login/form/');
        die();
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
