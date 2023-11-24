<?php

namespace Slimmvc\Provider;

use Slimmvc\App;
use Slimmvc\Http\TokenAuthentication;

class HttpAuthenticationProvider implements Provider {

    const BEAN_NAME = TokenAuthentication::class;

    public function bind(App $app): void {
        $app->bind(self::BEAN_NAME, function (App $app) {
            return new TokenAuthentication();
        });
    }

}