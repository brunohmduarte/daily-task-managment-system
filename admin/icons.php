<?php

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__).'/src/Core.php');

use Application\Core;

Core::existsSession('user');

Core::initTwig('admin');

Core::redirect('templates/icons.html');

