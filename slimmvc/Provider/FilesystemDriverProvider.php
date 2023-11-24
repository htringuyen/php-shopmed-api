<?php

namespace Slimmvc\Provider;

use Slimmvc\App;
use Slimmvc\Filesystem\LocalFilesystemDriver;

class FilesystemDriverProvider implements Provider {
    const BEAN_NAME = LocalFilesystemDriver::class;

    public function bind(App $app): void {
        $app->bind(self::BEAN_NAME, function($app) {
            return new LocalFilesystemDriver();
        });
    }
}