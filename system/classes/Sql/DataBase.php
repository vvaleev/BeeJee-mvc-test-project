<?php

namespace System\Sql;

use PDO;
use PDOException;
use stdClass;

class DataBase
{
    private static $_instance;

    private static $_pdo;

    private static $_pdoStatement;

    private static $_typeDatabase = 'mysql';

    private static $_hostname = 'localhost';

    private static $_port = 3306;

    private static $_dbname;

    private static $_charset = 'utf8';

    private static $_username;

    private static $_password;

    private static $_options = [];

    private static $_dsn;

    private function __construct()
    {
        self::$_dsn = self::$_typeDatabase . ':host=' . self::$_hostname . ';port=' . self::$_port . ';dbname=' . self::$_dbname . ';charset=' . self::$_charset;

        try {
            self::$_pdo = new PDO(self::$_dsn, self::$_username, self::$_password, self::$_options);
        } catch (PDOException $error) {
            die('Failed to connect to database. Reason: ' . $error->getMessage());
        }
    }

    public static function setTypeDatabase($typeDatabase)
    {
        self::$_typeDatabase = $typeDatabase;
    }

    public static function setHostname($hostname)
    {
        self::$_hostname = $hostname;
    }

    public static function setPort($port)
    {
        self::$_port = $port;
    }

    public static function setDbname($dbname)
    {
        self::$_dbname = $dbname;
    }

    public static function setCharset($charset)
    {
        self::$_charset = $charset;
    }

    public static function setUsername($username)
    {
        self::$_username = $username;
    }

    public static function setPassword($password)
    {
        self::$_password = $password;
    }

    public static function setOption($parameter, $value)
    {
        self::$_options[$parameter] = $value;
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function bindParam($parameter, $variable, $dataType = PDO::PARAM_STR, $length = 0)
    {
        $status = 0;

        if (self::$_pdo instanceof PDO && isset(self::$_pdoStatement)) {
            if ($length) {
                $status = self::$_pdoStatement->bindParam($parameter, $variable, $dataType, $length);
            } else {
                $status = self::$_pdoStatement->bindParam($parameter, $variable, $dataType);
            }
        }

        return $status;
    }

    public static function execute($isSelect = false)
    {
        $status = 0;
        $result = new stdClass();

        $result->row = [];
        $result->rows = [];
        $result->num_rows = 0;

        try {
            if (isset(self::$_pdoStatement)) {
                $status = self::$_pdoStatement->execute();

                if ($status && $isSelect === true) {
                    $result = self::prepareResult();
                }
            }
        } catch (PDOException $error) {
            die('Error: ' . $error->getMessage() . '. Error Code: ' . $error->getCode());
        }

        return $isSelect !== true ? $status : $result;
    }

    public static function query($query, $isSelect = false, $parameters = [])
    {
        self::prepare($query);

        $status = 0;
        $result = new stdClass();

        $result->row = [];
        $result->rows = [];
        $result->num_rows = 0;

        try {
            if (isset(self::$_pdoStatement)) {
                $status = self::$_pdoStatement->execute($parameters);

                if ($status && $isSelect === true) {
                    $result = self::prepareResult();
                }
            }
        } catch (PDOException $error) {
            die('Error: ' . $error->getMessage() . '. Error Code: ' . $error->getCode() . '. Query: ' . $query);
        }

        return $isSelect !== true ? $status : $result;
    }

    public static function prepare($query)
    {
        if (self::$_pdo instanceof PDO) {
            self::$_pdoStatement = self::$_pdo->prepare($query);
        }

        return !empty(self::$_pdoStatement->queryString) ? self::$_pdoStatement->queryString : null;
    }

    public static function quote($string)
    {
        if (self::$_pdo instanceof PDO) {
            return self::$_pdo->quote($string, self::prepareParamType($string));
        }

        return $string;
    }

    public static function bindParameter($parameter, $variable, $length = 0)
    {
        return self::bindParam($parameter, $variable, self::prepareParamType($variable), $length);
    }

    private static function prepareParamType($value)
    {
        $type = gettype($value);
        $dataType = PDO::PARAM_NULL;

        if ($type === 'integer') {
            $dataType = PDO::PARAM_INT;
        } elseif ($type === 'string') {
            $dataType = PDO::PARAM_STR;
        } elseif ($type === 'boolean') {
            $dataType = PDO::PARAM_BOOL;
        }

        return $dataType;
    }

    private static function prepareResult()
    {
        $data = self::prepareData();
        $result = new stdClass();

        $result->row = isset($data[0]) ? $data[0] : [];
        $result->rows = $data;
        $result->num_rows = self::$_pdoStatement->rowCount();

        return $result;
    }

    private static function prepareData()
    {
        $data = [];

        while ($row = self::$_pdoStatement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function __destruct()
    {
        self::$_instance = null;
        self::$_pdo = null;
        self::$_pdoStatement = null;
    }
}
