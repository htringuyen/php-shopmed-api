<?php
namespace Slimmvc\Provider;
use Slimmvc\App;
use Slimmvc\Config;

class ConfigProvider implements Provider
{
    const BEAN_NAME = Config::class;

    public function bind(App $app): void
    {
        $app->bind(self::BEAN_NAME, function($app) {
            return new Config();
        });
    }

}