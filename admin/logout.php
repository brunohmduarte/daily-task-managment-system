<?php

session_start();

require_once dirname(__DIR__).'/vendor/autoload.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Você não tem permissão para acessar essa página! Por favor, faça o login com suas credenciais válida.';
    die(header("Location: ". URL_BASE));
}

unset($_SESSION['user']);

die(header("Location: ". URL_BASE));