<?php

namespace Slimmvc\Database\Connection;

use Slimmvc\Database\Connection\Connection;
use Slimmvc\Database\QueryBuilder\MysqlQueryBuilder;
use InvalidArgumentException;
use Pdo;

class MysqlConnection extends Connection
{
    private Pdo $pdo;

    public function __construct(array $config)
    {
        [
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password,
        ] = $config;

        if (empty($host) || empty($database) || empty($username)) {
            throw new InvalidArgumentException('Connection incorrectly configured');
        }

        $this->pdo = new Pdo("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
    }

    public function pdo(): Pdo
    {
        return $this->pdo;
    }
    
    public function query(): MysqlQueryBuilder
    {
        return new MysqlQueryBuilder($this);
    }
}
