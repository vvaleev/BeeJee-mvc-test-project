<?php

spl_autoload_register(
    static function ($class) {
        $len = strlen(AUTOLOAD_PREFIX);

        if (strncmp(AUTOLOAD_PREFIX, $class, $len) !== 0) {
            return;
        }

        $relativeClass = substr($class, $len);
        $file = AUTOLOAD_BASE_DIR . str_replace('\\', '/', $relativeClass) . '.php';

        if (is_file($file)) {
            require_once($file);
        }
    }
);
