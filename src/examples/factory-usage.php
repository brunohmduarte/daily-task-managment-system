<?php
// Example usage of the Application\Factory\Factory
require_once __DIR__ . '/../../vendor/autoload.php';

use Application\Factory\Factory;

// 1) Create an instance by fully-qualified class name (short form allowed)
// If you want to create Application\Model\User you can pass either:
$user = Factory::create('Model\\User'); // will resolve to Application\Model\User
var_dump(get_class($user));

// 2) Create with constructor parameters (if class constructor accepts args)
// $obj = Factory::create('Some\\Class', ['arg1', 'arg2']);

// 3) Bind an alias to a resolver (useful for services)
Factory::bind('mailer', function($params) {
    // resolver may create a service with custom configuration
    // example: return new \Application\Services\Mailer($params[0] ?? null);
    return (object)[ 'service' => 'dummy-mailer', 'params' => $params ];
});

$mailer = Factory::create('mailer', ['smtp.example.com']);
var_dump($mailer);

// Notes:
// - Use Factory::create('Model\\User') or Factory::create('Application\\Model\\User')
// - For convenience you can pass short names without the Application\\ prefix
// - If a class doesn't exist an InvalidArgumentException is thrown

