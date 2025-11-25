<?php

// phpinfo(); exit;

session_start();

$vendorFolder = __DIR__.'/vendor';
$autoloadFile = $vendorFolder.'/autoload.php';

if (!file_exists($vendorFolder) || !file_exists($autoloadFile)) {
    die(header('Location: maintenance.php'));
}

die(header('Location: login.php'));