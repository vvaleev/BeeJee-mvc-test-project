<?php

namespace System\Document;

class Page
{
    public static function renderJs($fileName)
    {
        echo self::getJs($fileName);
    }

    public static function getJs($fileName)
    {
        $file = self::prepareFile($fileName, 'js');

        if (self::checkFile($file)) {
            global $_ROOT_DIRECTORY;

            $fileUnixTime = filemtime($_ROOT_DIRECTORY . $file);
            return "<script src=\"{$file}?ut={$fileUnixTime}\"></script>";
        }

        return null;
    }

    public static function renderCss($fileName)
    {
        echo self::getCss($fileName);
    }

    public static function getCss($fileName)
    {
        $file = self::prepareFile($fileName, 'css');

        if (self::checkFile($file)) {
            global $_ROOT_DIRECTORY;

            $fileUnixTime = filemtime($_ROOT_DIRECTORY . $file);
            return " <link rel=\"stylesheet\" href=\"{$file}?ut={$fileUnixTime}\" />";
        }

        return null;
    }

    private static function prepareFile($fileName, $extension)
    {
        return '/' . SITE_PUBLIC_DIR_NAME . '/' . $extension . '/' . $fileName . '.' . $extension;
    }

    private static function checkFile($file)
    {
        global $_ROOT_DIRECTORY;

        if (is_file($_ROOT_DIRECTORY . $file)) {
            return true;
        }

        return false;
    }
}
