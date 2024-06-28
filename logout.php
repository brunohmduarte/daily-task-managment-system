<?php

session_start();

require_once(__DIR__.'/vendor/autoload.php');

use Application\Core;

if (!isset($_SESSION['user'])) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Você não tem permissão para acessar essa página! Por favor, faça o login com suas credenciais válida.';
    die(header("Location: ". Core::getUrlBase()));
}

unset($_SESSION['user']);

die(header("Location: ". Core::getUrlBase()));
