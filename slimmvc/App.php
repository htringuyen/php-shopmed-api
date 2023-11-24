<?php
namespace Slimmvc;

use Dotenv\Dotenv;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Provider\HttpResponseProvider;
use Slimmvc\Routing\Router;

class App extends Container {
    private static $instance;

    public static function getInstance() {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    private function __construct() {

    }

    private function __clone() {

    }

    public function prepare(): static
    {
        $basePath = $this->resolve('paths.base');

        $this->configure($basePath);
        $this->bindProviders($basePath);

        return $this;
    }


    public function run(): HttpResponse
    {
        return $this->dispatch($this->resolve('paths.base'));
    }


    private function configure(string $basePath)
    {
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }


    private function bindProviders(string $basePath)
    {
        $providers = require "{$basePath}/config/providers.php";

        foreach ($providers as $provider) {
            $instance = new $provider;

            if (method_exists($instance, 'bind')) {
                $instance->bind($this);
            }
        }
    }

    private function loadEnvVars(string $basePath): void {
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }

    public function dispatch(string $basePath): HttpResponse {
        if (! $this->has(Router::class)) {
            $router = new Router();

            $SEP = DIRECTORY_SEPARATOR;

            $loadRoutes = require $basePath.$SEP."app".$SEP."routes.php";
            $loadRoutes($router);

            $this->bind(Router::class, fn() => $router);
        }

        $content = $this->resolve(Router::class)->dispatch();

        if (!$content instanceof HttpResponse) {
            $response = $this->resolve(HttpResponseProvider::BEAN_NAME);
            $response->setContent($content);
            return $response;
        }

        return $content;
    }
}
























