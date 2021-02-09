<?php

namespace System;

abstract class Controller
{
    /** @var Model $model */
    protected $model;

    /** @var View $view */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
    }

    abstract public function __default();

    public function loadModel($modelName)
    {
        if ($modelName && class_exists($modelName)) {
            $this->model = new $modelName();
        }

        return $this;
    }

    public function loadView()
    {
        if (class_exists('\System\View')) {
            $this->view = new View();
        }

        return $this;
    }

    /**
     * Controller destructor.
     */
    public function __destruct()
    {
    }
}
