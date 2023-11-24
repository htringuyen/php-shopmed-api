<?php

namespace Slimmvc\Provider;

use Slimmvc\App;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

class HttpResponseProvider implements Provider
{
    const BEAN_NAME = HttpResponse::class;

    public function bind(App $app): void {
        $app->bind(self::BEAN_NAME, function ($app) {
            return new HttpResponse();
        });
    }
}