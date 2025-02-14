<?php

namespace Application\Model\Resources;

use CoffeeCode\DataLayer\Connect;

class DataDefinition extends Connect
{
    public $connection;

    public function __construct()
    {
        $this->connection = Connect::getInstance();
    }

    public function getTables()
    {
        return $this->connection->query('SHOW TABLES')->fetchAll();
    }

    public function existsDatabase(string $databaseName): bool
    {
        return (bool) $this->connection->query("SHOW DATABASES LIKE '{$databaseName}';")->rowCount();
    }

    public function dropDatabase(string $databaseName): bool
    {
        if (!$this->existsDatabase($databaseName)) {
            return false;
        }
        $result = $this->connection->exec("DROP DATABASE IF EXISTS `{$databaseName}`;");
        return $result !== false;
    }
}