<?php

namespace System\Files;

class File
{
    private static $path = '/upload/';

    private $hash;

    public static function getPath()
    {
        return self::$path;
    }

    public static function setPath($path)
    {
        self::$path = $path;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function upload($fileData, $types, $minSize = 0, $maxSize = 0)
    {
        if (!is_array($types)) {
            $types = [];
        }

        $minSize = (int)$minSize;
        $maxSize = (int)$maxSize;

        if (!isset($fileData['NAME'], $fileData['TYPE'], $fileData['TMP_NAME'], $fileData['ERROR'], $fileData['SIZE']) || !$fileData) {
            die('Invalid file data. Error code: 404');
        }

        if (!in_array($fileData['TYPE'], $types, true)) {
            die('Forbidden file type: "' . $fileData['TYPE'] . '". Error code: 404');
        }

        if ($fileData['ERROR'] !== UPLOAD_ERR_OK) {
            die('An error occurred while uploading the file. Error Code: ' . $fileData['ERROR'] . '. Error code: 501');
        }

        if ((int)$fileData['SIZE'] === 0) {
            die('Invalid file size. Error code: 404');
        }

        if ($maxSize === 0) {
            $maxSize = (int)$fileData['SIZE'];
        }

        if ((int)$fileData['SIZE'] < $minSize) {
            die('Invalid file size. Recommended minimum size ' . $minSize . ' bytes. Error code: 404');
        }

        if ((int)$fileData['SIZE'] > $maxSize) {
            die('Invalid file size. Recommended maximum size ' . $maxSize . ' bytes. Error code: 404');
        }

        $fileHash = self::generateHash("{$fileData['NAME']}_{$fileData['SIZE']}");

        if (self::$path && $fileHash) {
            if (!is_file(self::$path . $fileHash)) {
                if (
                    move_uploaded_file($fileData['TMP_NAME'], self::$path . $fileHash)
                    && chmod(self::$path . $fileHash, FILE_PERMISSIONS)
                ) {
                    $this->hash = $fileHash;
                }
            } else {
                $this->hash = $fileHash;
            }
        }

        return $this->hash;
    }

    public function render()
    {
        if (
            self::$path && $this->hash
            && is_file(self::$path . $this->hash)
            && $data = self::getDataFromFile(self::$path . $this->hash)
        ) {
            header('Content-Type: ' . mime_content_type(self::$path . $this->hash));
            header('Content-Length: ' . filesize(self::$path . $this->hash) . '; ');
            header('Expires: 0');

            return $data;
        }

        return null;
    }

    private static function generateHash($key)
    {
        if (!$key) {
            return null;
        }

        return substr(sha1($key . md5('vvm')), 0, 32);
    }

    private static function getDataFromFile($file)
    {
        $data = null;

        if (is_file($file) && !($data = file_get_contents($file))) {
            die('Data not received. Error code: 204');
        }

        return $data;
    }
}
