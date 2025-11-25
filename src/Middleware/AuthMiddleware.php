<?php

namespace Application\Middleware;

class AuthMiddleware
{
    public static function checkAccess($requiredRole = null)
    {
        session_start();
        // echo '<pre>', print_r($_SESSION, true ), '</pre>';
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_authenticated']) {
            $_SESSION['error']['status'] = true;
            $_SESSION['error']['message'] = 'Você precisa estar logado para acessar esta página.';
            header('Location: /login.php');
            exit;
        }
        // Verifica permissão por role, se necessário
        if ($requiredRole && (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== $requiredRole)) {
            $_SESSION['error']['status'] = true;
            $_SESSION['error']['message'] = 'Você não tem permissão para acessar esta página.';
            header('Location: /login.php');
            exit;
        }
    }
}
