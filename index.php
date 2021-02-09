<?php

$_ROOT_DIRECTORY = str_replace('\\', '/', realpath(__DIR__));

if (is_file($_ROOT_DIRECTORY . '/system/config/site.php')) {
    require_once($_ROOT_DIRECTORY . '/system/config/site.php');
}

if (
    is_file($_ROOT_DIRECTORY . '/system/config/autoload.php')
    && is_file($_ROOT_DIRECTORY . '/system/app_start/autoload.php')
) {
    require_once($_ROOT_DIRECTORY . '/system/config/autoload.php');
    require_once($_ROOT_DIRECTORY . '/system/app_start/autoload.php');
}

if (
    is_file($_ROOT_DIRECTORY . '/system/config/route.php')
    && is_file($_ROOT_DIRECTORY . '/system/app_start/Route.php')
) {
    require_once($_ROOT_DIRECTORY . '/system/config/route.php');
    require_once($_ROOT_DIRECTORY . '/system/app_start/Route.php');

    Route::Init((!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null);

    if (Route::isInit()) {
        return;
    }
}

if (is_file($_ROOT_DIRECTORY . '/public/index.php')) {
    require_once($_ROOT_DIRECTORY . '/' . SITE_PUBLIC_DIR_NAME . '/index.php');
}
