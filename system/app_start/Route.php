<?php

use System\Controller;

final class Route
{
    private static $isInit = false;

    public static function Init($requestUri)
    {
        if (!$requestUri) {
            return false;
        }

        $requestUriData = explode('?', $requestUri);
        $path = preg_replace('/\/+/', '/', isset($requestUriData[0]) ? $requestUriData[0] : null);
        $pathData = explode('/', trim($path, '/'));

        if (sizeof($pathData) >= 1) {
            $controller = self::getControllerName(!empty($pathData[0]) ? $pathData[0] : null);
            $model = self::getModelName(!empty($pathData[0]) ? $pathData[0] : null);
            $action = self::getActionName(!empty($pathData[1]) ? $pathData[1] : null);
            $parameter = self::getParameterName(!empty($pathData[2]) ? $pathData[2] : null);

            if (
                self::connectBaseController() &&
                self::connectBaseModel() &&
                self::connectBaseView() &&
                self::connectController($controller) &&
                self::connectModel($model)
            ) {
                if (class_exists($controller)) {
                    /** @var Controller $controllerObject */
                    $controllerObject = new $controller();

                    if (method_exists($controller, 'loadModel')) {
                        $controllerObject->loadModel($model);
                    }

                    if (method_exists($controller, 'loadView')) {
                        $controllerObject->loadView();
                    }

                    if (method_exists($controller, $action)) {
                        if (empty($_REQUEST['IS_AJAX'])) {
                            $controllerObject->$action($parameter);
                        } else {
                            echo json_encode($controllerObject->$action($parameter));
                        }
                    }

                    self::$isInit = true;
                }
            }
        }

        return true;
    }

    public static function isInit()
    {
        return self::$isInit;
    }

    private static function getControllerName($controller)
    {
        return !empty($controller) ? (ucfirst(trim(urldecode($controller))) . ROUTE_CONTROLLER_PREFIX) : null;
    }

    private static function getModelName($model)
    {
        return !empty($model) ? (ucfirst(trim(urldecode($model))) . ROUTE_MODEL_PREFIX) : null;
    }

    private static function getActionName($action)
    {
        return !empty($action) ? (lcfirst(trim(urldecode($action))) . ROUTE_ACTION_PREFIX) : '__default';
    }

    private static function getParameterName($parameter)
    {
        return !empty($parameter) ? trim(urldecode($parameter)) : null;
    }

    private static function connectBaseController()
    {
        $file = ROUTE_BASE_DIR . 'Controller.php';

        if (is_file($file)) {
            require_once($file);

            return true;
        }

        return false;
    }

    private static function connectBaseModel()
    {
        $file = ROUTE_BASE_DIR . 'Model.php';

        if (is_file($file)) {
            require_once($file);

            return true;
        }

        return false;
    }

    private static function connectBaseView()
    {
        $file = ROUTE_BASE_DIR . 'View.php';

        if (is_file($file)) {
            require_once($file);

            return true;
        }

        return false;
    }

    private static function connectController($controllerName)
    {
        $file = ROUTE_CONTROLLER_DIR . $controllerName . '.php';

        if (is_file($file)) {
            require_once($file);

            return true;
        }

        return false;
    }

    private static function connectModel($modelName)
    {
        $file = ROUTE_MODEL_DIR . $modelName . '.php';

        if (is_file($file)) {
            require_once($file);

            return true;
        }

        return false;
    }
}
