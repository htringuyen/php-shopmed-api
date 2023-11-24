<?php

namespace Slimmvc\Database\Connection;

use Slimmvc\Database\QueryBuilder\QueryBuilder;
use Pdo;

abstract class Connection
{
    /**
     * Get the underlying Pdo instance for this connection
     */
    abstract public function pdo(): Pdo;

    /**
     * Start a new query on this connection
     */
    abstract public function query(): QueryBuilder;
}
