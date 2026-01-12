<?php

namespace Application\Core;

class Factory
{
    /**
     * Custom bindings: alias => callable
     * callable receives array $params and should return an instance
     */
    protected static array $bindings = [];

    /**
     * Bind an alias to a resolver callable
     * Example: Factory::bind('mailer', fn($p) => new Mailer(...$p));
     */
    public static function bind(string $alias, callable $resolver): void
    {
        self::$bindings[$alias] = $resolver;
    }

    /**
     * Create an instance of a class.
     * - If $class matches a bound alias, the resolver is invoked.
     * - Otherwise the class name is normalized to the Application\ namespace if needed and instantiated.
     * - $params is forwarded to the constructor.
     * Throws InvalidArgumentException if class not found.
     */
    public static function create(string $class, array $params = [])
    {
        // If bound resolver exists, use it
        if (isset(self::$bindings[$class])) {
            return call_user_func(self::$bindings[$class], $params);
        }

        // Normalize class name: allow passing short names like "Model\User" or "Model\\User"
        $fqcn = $class;
        // If class does not start with backslash and does not already start with Application\, prefix it
        // if ($fqcn !== '' && $fqcn[0] !== '\\' && strncmp($fqcn, 'Application\\', 12) !== 0) {
        //     $fqcn = 'Application\\' . ltrim($fqcn, '\\');
        // }

        // If user passed a leading backslash, strip it for class_exists
        $check = ltrim($fqcn, '\\');

        if (!class_exists($check)) {
            throw new \InvalidArgumentException(sprintf('Factory: class "%s" not found', $check));
        }

        $ref = new \ReflectionClass($check);
        if (empty($params)) {
            return $ref->newInstance();
        }

        return $ref->newInstanceArgs($params);
    }
}
