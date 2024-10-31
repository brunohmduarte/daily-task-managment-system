<?php

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__).'/src/Core.php');

use Application\Core;

date_default_timezone_set('America/Sao_Paulo');

Core::existsSession('user');
Core::initTwig('admin');

$params = ['TITLE' => 'Dashboard'];

// Mensagens de alerta.
if (isset($_SESSION['admin_error'])) {
    $params['ERROR_ALERT'] = Core::getAlertMessage('admin_error');
}

if (isset($_SESSION['admin_success'])) {
    $params['SUCCESS_ALERT'] = Core::getAlertMessage('admin_success');
}

Core::redirect('templates/dashboard/index.html.twig', $params);

