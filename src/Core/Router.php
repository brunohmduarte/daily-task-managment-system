<?php
namespace Application\Core;

class Router
{
    /**
     * Handlers registered: action => callable
     */
    protected static array $handlers = [];

    /**
     * Register a handler for an action
     * Example: Router::on('getTicketStats', [$controller, 'getTicketStats'])
     */
    public static function on(string $action, callable $handler): void
    {
        self::$handlers[$action] = $handler;
    }

    /**
     * Dispatch request based on action parameter
     * Returns JSON response
     */
    public static function dispatch(string $paramName = 'action'): void
    {
        // Get action from query string
        $action = $_GET[$paramName] ?? null;

        if (!$action) {
            self::jsonResponse(400, 'Action parameter not provided', null);
        }

        // Check if handler exists
        if (!isset(self::$handlers[$action])) {
            self::jsonResponse(404, sprintf('Action "%s" not found', $action), null);
        }

        try {
            // Execute handler and get response
            $handler = self::$handlers[$action];
            $result = call_user_func($handler);

            // Return successful response
            self::jsonResponse(200, 'Success', $result);
        } catch (\Exception $e) {
            // Return error response
            self::jsonResponse(500, 'Error: ' . $e->getMessage(), null);
        }
    }

    /**
     * Send JSON response
     */
    protected static function jsonResponse(int $code, string $message, $data = null): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        $response = [
            'status' => $code >= 400 ? 'error' : 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Get a parameter from $_GET or $_POST
     */
    public static function getParam(string $name, $default = null)
    {
        return $_GET[$name] ?? $_POST[$name] ?? $default;
    }
}
