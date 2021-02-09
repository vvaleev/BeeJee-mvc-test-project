<?php

class MainModel extends System\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getData($param)
    {
        return [
            __CLASS__ => [
                'Parameter' => $param
            ]
        ];
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
