<?php

namespace System;

abstract class Model
{
    /**
     * Model constructor.
     */
    public function __construct()
    {
    }

    abstract public function getData($param);

    /**
     * Model destructor.
     */
    public function __destruct()
    {
    }
}
