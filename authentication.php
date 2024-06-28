<?php

session_start();

require_once(__DIR__.'/vendor/autoload.php');

use Application\Core;
use Application\Model\Users\User;
use CoffeeCode\DataLayer\Connect;

$con = Connect::getInstance();
$error = Connect::getError();

if ($error) {
    echo $error->getMessage();
    die();
}

Core::initTwig();

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = filter_var($_POST['password'], FILTER_DEFAULT);

if (empty($password) || empty($email)) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Usuário/Senha inválido!';
    die(header("Location: ". Core::getUrlBase()));
}

$user = new User();
$params = http_build_query(array(
    'email' => $email,
    'password'  => $password
));

$stmt = $user->find('email = :email AND password = :password', $params);

// Unregistered user
if (empty($stmt->fetch())) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Não há usuário cadastrado com esse e-mail!';
    die(header("Location: ". Core::getUrlBase()));
}

// Duplicate user
if ($stmt->count() > 1) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Não foi possível realizar o login! Por gentileza, contate o administrador do sistema.';
    die(header("Location: ". Core::getUrlBase()));
}

// Active user
$userData = $stmt->fetch()->data();
if ($userData->active != 1) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Este usuário está inativo! Por gentileza, contate o administrador do sistema.';
    die(header("Location: ". Core::getUrlBase()));
}

// Session initialized
if (!empty($_SESSION['user'])) {
    die(header('Location: '. Core::getUrlBase('admin/dashboard.php')));
}

// Session create
$_SESSION['user']['user_id']    = $userData->user_id;
$_SESSION['user']['name']       = $userData->name;
$_SESSION['user']['email']      = $userData->email;
$_SESSION['user']['password']   = $userData->password;
$_SESSION['user']['active']     = $userData->active;
$_SESSION['user']['avatar']     = $userData->avatar;
$_SESSION['user']['created_at'] = $userData->created_at;
$_SESSION['user']['updated_at'] = $userData->updated_at;

die(header('Location: '. Core::getUrlBase('admin/dashboard.php')));
