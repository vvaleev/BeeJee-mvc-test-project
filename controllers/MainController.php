<?php

class MainController extends System\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __default()
    {
        $this->view->render('404');
    }

    public function pageAction($param)
    {
        $this->view->render('main', $this->model->getData($param));
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
