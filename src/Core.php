<?php

namespace Application;

require_once(__DIR__.'/Config.php');

final class Core 
{
    public static $twig;

    public static function initTwig(string $environment = 'front') 
    {
        $local = ($environment == 'admin') ? '../views/admin' : 'views';

        if (empty(self::$twig)) {
            $loader = new \Twig\Loader\FilesystemLoader($local);
            self::$twig = new \Twig\Environment($loader, [
                'cache' => false, //'var/cache/',
                'debug' => true,
                'charset' => 'utf-8',
                'auto_reload' => true,
                'strict_variables' => true
            ]);
            self::$twig->addExtension(new \Twig\Extension\DebugExtension());
        }
        return self::$twig;
    }

    public static function redirect(string $page, array $params = []) 
    {
        $params['URL_BASE'] = URL_BASE;
        self::$twig->display($page, $params);
    }

    public static function getUrlBase(string $route = ''): string
    {
        if (empty($route)) {
            return URL_BASE;
        }
        return sprintf('%s/%s', URL_BASE, $route);
    }

    public static function getFullFilePath($filepath) 
    {
        if (!is_string($filepath) && empty($filepath)) {
            return;
        }
        return sprintf('%s/%s', $_SERVER['DOCUMENT_ROOT'], $filepath);
    }

    public static function resetAlertMessage() 
    {
        if (isset($_SESSION['admin_error']) || 
            isset($_SESSION['admin_success']) || 
            isset($_SESSION['admin_warning'])
        ) {
            unset($_SESSION['admin_error']);
            unset($_SESSION['admin_success']);
            unset($_SESSION['admin_warning']);
        }
    }

    public static function errorSession(string $message, bool $isMultiMsg = false) 
    {
        if (empty($message)) {
            return null;
        }
        if ($isMultiMsg === true) {
            $_SESSION['admin_error']['message'][] = $message;
        }
        $_SESSION['admin_error']['message'] = $message;
    }

    public static function successSession(string $message, bool $isMultiMsg = false) 
    {
        if (empty($message)) {
            return null;
        }
        if ($isMultiMsg === true) {
            $_SESSION['admin_success']['message'][] = $message;
        }
        $_SESSION['admin_success']['message'] = $message;
    }

    public static function warningSession(string $message, bool $isMultiMsg = false) 
    {
        if (empty($message)) {
            return null;
        }
        if ($isMultiMsg === true) {
            $_SESSION['admin_warning']['message'][] = $message;
        }
        $_SESSION['admin_warning']['message'] = $message;
    }

    public static function getAlertMessage(string $sessionName) 
    {
        $message = $_SESSION[$sessionName]['message'];
        if (gettype($message) === 'string') {
            return [$message];
        }
        return $message;
    }

    public static function existsSession(string $sessionName) 
    {
        if (empty($sessionName)) {
            $_SESSION['error']['status'] = true;
            $_SESSION['error']['message'] = 'Você não tem permissão para acessar essa página! A sessão não foi definida.';
            die(header("Location: ". Core::getUrlBase()));
        }

        if (!isset($_SESSION[$sessionName])) {
            $_SESSION['error']['status'] = true;
            $_SESSION['error']['message'] = 'Você não tem permissão para acessar essa página! Por favor, faça o login com suas credenciais e tente novamente.';
            die(header("Location: ". Core::getUrlBase()));
        }
    }

}
