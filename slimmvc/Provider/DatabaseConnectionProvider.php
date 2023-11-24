<?php

namespace Slimmvc\Provider;

use Slimmvc\Database\Connection\MysqlConnection;
use Slimmvc\App;

class DatabaseConnectionProvider implements Provider
{
    const BEAN_NAME = MysqlConnection::class;

    public function bind(App $app): void {
        $app->bind(self::BEAN_NAME, function($app) {
            return new MysqlConnection(config("database.mysql"));
        });
    }
}