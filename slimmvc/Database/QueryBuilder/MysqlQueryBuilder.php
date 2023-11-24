<?php

namespace Slimmvc\Database\QueryBuilder;

use Slimmvc\Database\Connection\MysqlConnection;

class MysqlQueryBuilder extends QueryBuilder
{
    protected MysqlConnection $connection;

    public function __construct(MysqlConnection $connection)
    {
        $this->connection = $connection;
    }
}
