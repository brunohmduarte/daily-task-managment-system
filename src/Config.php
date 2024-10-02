<?php

$protocol = ($_SERVER['HTTPS'] !== 'on') ? 'http://' : 'https://';

define('URL_BASE', $protocol . 'daily.dvl.to');

define('DATA_LAYER_CONFIG', [
    "driver" => "mysql",
    "host" => "127.0.0.1",
    "port" => "3306",
    "dbname" => "daily",
    "username" => "root",
    "passwd" => "magento",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);
