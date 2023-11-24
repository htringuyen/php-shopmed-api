<?php

namespace Slimmvc\Provider;

use Slimmvc\App;

interface Provider
{
    public function bind(App $app): void;
}