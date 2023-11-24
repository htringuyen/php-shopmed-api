<?php

namespace Slimmvc\Provider;

use Slimmvc\App;
use Slimmvc\Http\HttpRequest;

class HttpRequestProvider implements Provider {
    const BEAN_NAME= HttpRequest::class;

    public function bind(App $app): void {
        $app->bind(self::BEAN_NAME, function($app) {
            return new HttpRequest(null);
        });
    }
}