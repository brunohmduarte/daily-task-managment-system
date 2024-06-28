<?php

// phpinfo(); exit;

session_start();

require_once(__DIR__.'/vendor/autoload.php');
require_once(__DIR__.'/src/Core.php');

use Application\Core;

Core::initTwig();

$params = [];

if (isset($_SESSION['error']) && $_SESSION['error']['status'] === true) {
    $params['ERROR'] = $_SESSION['error']['message'];
    unset($_SESSION['error']);
}

Core::redirect('index.html.twig', $params);
