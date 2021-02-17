<?php

class TaskController extends System\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __default()
    {
        $this->view->render('404');
    }

    public function listAction($param)
    {
        if ($param === 'get') {
            $data = $this->model->getData($param);

            if (!empty($data)) {
                return ['data' => $data];
            }
        }

        return [];
    }

    public function getAction($id)
    {
        if (empty($id)) {
            return [];
        }

        return ['result' => $this->model->getById($id)];
    }

    public function addAction($param)
    {
        if (
            !empty($_POST['name'])
            && !empty($_POST['description'])
            && !empty($_POST['email'])
            && !empty($_POST['status'])
            && in_array($_POST['status'], ['1', '2'], true)
        ) {
            if ($this->model->saveData(escapeData($_POST))) {
                return ['result' => true];
            }
        }

        return ['result' => false];
    }

    public function editAction($id)
    {
        if (
            !empty($id)
            && !empty($_POST['name'])
            && !empty($_POST['description'])
            && !empty($_POST['email'])
            && !empty($_POST['status'])
            && in_array($_POST['status'], ['1', '2', '3'], true)
        ) {
            if ($this->model->editById($id, escapeData($_POST))) {
                return ['result' => true];
            }
        }

        return ['result' => false];
    }

    public function removeAction($id)
    {
        $intId = (int)$id;

        if ($intId && $this->model->removeById($intId)) {
            header('Location: /');
            die();
        }

        echo 'Access failed';
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
