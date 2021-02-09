<?php

use System\Sql\DataBase;

DataBase::setTypeDatabase('mysql');
DataBase::setHostname('localhost');
DataBase::setPort(3306);
DataBase::setDbname('');
DataBase::setCharset('utf8');
DataBase::setUsername('root');
DataBase::setPassword('');
DataBase::setOption(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
DataBase::setOption(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
DataBase::setOption(PDO::ATTR_EMULATE_PREPARES, true);
