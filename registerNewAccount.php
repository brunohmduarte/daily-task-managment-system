<?php

session_start();

require_once(__DIR__.'/vendor/autoload.php');

use Application\Model\User;
use CoffeeCode\DataLayer\Connect;

$con = Connect::getInstance();
$error = Connect::getError();

if ($error) {
    echo $error->getMessage();
    die();
}

// Sanitize and validate input
$name     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = filter_var($_POST['password'], FILTER_DEFAULT);
$passwordConfirm = filter_var($_POST['passwordConfirm'], FILTER_DEFAULT);

// Armazenar dados do formulário na sessão para reutilização
$_SESSION['form_data'] = [
    'name' => $name,
    'email' => $email
];

// Validate required fields
if (empty($name) || empty($password) || empty($email) || empty($passwordConfirm)) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Todos os campos são obrigatórios!';
    die(header("Location: signup.php"));
}

// Validate password confirmation
if ($password !== $passwordConfirm) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'As senhas não correspondem!';
    die(header("Location: signup.php"));
}

// Check if email already exists
$user = new User();
if ($user->emailExists($email)) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'E-mail já cadastrado!';
    die(header("Location: signup.php"));
}

// Create new user
$user->name = $name;
$user->email = $email;
$user->password = $password;
$user->active = 1;
$isCreated = $user->save();

// Redirect to login page
if (!$isCreated) {
    $_SESSION['error']['status'] = true;
    $_SESSION['error']['message'] = 'Erro ao cadastrar usuário! Tente novamente.';
    die(header("Location: signup.php"));
}

$_SESSION['success']['status'] = true;
$_SESSION['success']['message'] = 'Usuário cadastrado com sucesso!';

// Limpar dados do formulário após sucesso
unset($_SESSION['form_data']);

die(header("Location: login.php"));
