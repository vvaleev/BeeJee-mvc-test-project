<?php

namespace System;

final class View
{
    /**
     * View constructor.
     */
    public function __construct()
    {
    }

    public static function render($templateId, $data = [])
    {
        self::renderView($templateId, $data);
    }

    public static function renderView($templateId, $data = [])
    {
        if (!is_array($data)) {
            $data = [];
        }

        $file = ROUTE_VIEW_DIR . '/' . $templateId . '/template.php';

        if (is_file($file)) {
            require($file);
        }
    }

    /**
     * View destructor.
     */
    public function __destruct()
    {
    }
}
