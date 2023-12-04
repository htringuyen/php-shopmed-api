<?php

use Slimmvc\Routing\Router;

return function (Router $router, string $dirPathSeparator) {
    $routeFiles = [
        "routes_business.php",
        "routes_content.php",
        "routes_admin.php",
        "routes_common.php",
        "routes_dev.php",
    ];

    foreach ($routeFiles as $routeFile) {
        $loadRoutes = require $dirPathSeparator . $routeFile;
        $loadRoutes($router);
    }
};
