<?php

$protocol = ($_SERVER['HTTPS'] !== 'on') ? 'http://' : 'https://';

define('URL_BASE', $protocol . 'daily.dvl.to');
define('URL_EXTERNAL', 'https://coderthemes.com/shreyu');
define('LOAD_LINK_EXTERNAL', false);
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
    

/**
 * Return full URL based on given URL.
 *
 * If LOAD_LINK_EXTERNAL is true, use URL_EXTERNAL as domain,
 * otherwise use URL_BASE.
 *
 * @param string $url
 * @return string
 */
function getUrlFull(string $url): string
{
    $domain = (LOAD_LINK_EXTERNAL) ? URL_EXTERNAL : URL_BASE;
    return rtrim($domain, '/') . '/' . ltrim($url, '/');
}
