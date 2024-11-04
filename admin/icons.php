<?php

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__).'/src/Core.php');

use Application\Core;

date_default_timezone_set('America/Sao_Paulo');

Core::existsSession('user');
Core::initTwig('admin');
Core::redirect('templates/icons.html');
