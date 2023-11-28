<?php

namespace Slimmvc\Routing;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Provider\HttpAuthenticationProvider;
use Slimmvc\Routing\Exception\RouteException;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class Router {

    private array $routes = [];
    private array $errorHandler = [];
    private Route $current;

    public function __construct() {
        $this->errorHandler["default"] = function (int $status, mixed $message) {
            $response = app(HttpResponse::class);
            $response->setType(HttpResponse::JSON);
            $response->setStatus($status);
            $response->setContent($message);
            return $response;
        };
    }

    public function addRoute(string $method, string $path, callable|array $handler,
                             array $requiredParams = [],
                             bool $protected = false, mixed $authority = null): Route {
        $route = $this->routes[] = new Route($method, $path, $handler, $requiredParams, $protected, $authority);
        return $route;
    }

    public function addErrorHandler(int $code, array|callable $handler) {
        $this->errorHandler[$code] = $handler;
    }

    public function getCurrentRoute(): Route {
        return $this->current;
    }

    public function buildUrlWith(string $routeName, array $pathVariables, array $requestParams): string {
        foreach ($this->routes as $route) {
            if ($route->getName() === $routeName) {
                $finds = [];
                $replaces = [];

                foreach ($pathVariables as $key => $value) {
                    $finds[] = "{{$key}}";
                    $replaces[] = $value;

                    $finds[] = "{{$key}?}";
                    $replaces[] = $value;
                }

                $path = str_replace($finds, $replaces, $route->getPath());
                $path = preg_replace('#{[^}]+}#', '', $path);

                $urlQuery = "?";
                foreach ($requestParams as $key => $value) {
                    $urlQuery = $urlQuery."{$key}={$value}&";
                }

                $urlQuery = rtrim($urlQuery, "&");

                return $path.$urlQuery;
            }
        }

        throw new RouteException("No route that has the name {$routeName}");
    }

    public function dispatch() {
        $requestMethod = $_SERVER["REQUEST_METHOD"] ?? "GET";
        $url = $_SERVER["REQUEST_URI"] ?? "/";

        $candidateRoutes = $this->findCandidateRoutes($url);
        $hasPathMatched = ! empty($candidateRoutes);

        $candidateRoutes = self::filterByMethod($candidateRoutes, $requestMethod);
        $selectedRoute = self::selectByFirst($candidateRoutes);

        if (!is_null($selectedRoute) && $selectedRoute->isProtected()) {
            $authHeader = getallheaders()['Authorization'] ?? null;

            $isMatched = preg_match("/Bearer\s(\S+)/", $authHeader, $matches);

            if (! isset($authHeader) && ! $isMatched) {
                return $this->handleError(400, "Authorization header required but not found");
            }

            $userToken = $matches[1] ?? null;

            if (! isset($userToken)) {
                return $this->handleError(400,
                    "Not able to extract auth token from header");
            }

            $authentication = app(HttpAuthenticationProvider::BEAN_NAME);

            try {
                if (! $authentication->authenticate($userToken)) {
                    return $this->handleError(401, "Authorization failed!");
                }
            } catch (ExpiredException $ex) {
                return $this->handleError(401, "Expired token!");
            }
            catch (Exception $ex) {
                return $this->handleError(401, "Authorization failed!");
            }



            $routeAuthority = $selectedRoute->getAuthority();

            if (isset($routeAuthority) && ! $authentication->isEnoughAuthorityFor($routeAuthority)) {
                return $this->handleError(401, "Not enough authority!");
            }
        }

        if ($selectedRoute) {
            try {
                $this->current = $selectedRoute;
                return $selectedRoute->dispatch();
            }
            catch (Throwable $e) {
                $whoops = new Run();
                $whoops->pushHandler(new PrettyPageHandler());
                $whoops->register();
                throw $e;
                //return $this->dispatchError();
            }
        }

        if ($hasPathMatched) {
            return $this->dispatchNotAllowed();
        }

        return $this->dispatchNotFound();
    }

    private function findCandidateRoutes(string $url): array {

        return array_filter($this->routes, function(Route $route) use ($url) {

            return $route->matchUrl($url);
        });
    }

    private static function filterByMethod(array $routes, string $method): array {
        return array_filter($routes, function ($route) use ($method) {
            return $route->getMethod() === $method;
        });
    }

    private static function selectByFirst(array $routes): ?Route {
        if (!empty($routes)) {
            return array_values($routes)[0];
        }
        return null;
    }

    public function dispatchError() {
        $this->errorHandler[500] ??= fn() => "500 server error";
        return $this->errorHandler[500]();
    }

    public function dispatchNotAllowed() {
        $this->errorHandler[400] ??= fn() => "400 not allowed";
        return $this->errorHandler[400]();
    }

    public function dispatchNotFound() {
        $url = $_SERVER["REQUEST_URI"] ?? "/";
        $this->errorHandler[404] ??= fn() => "<h1>404 not found</h1></br><p>url_path={$url}</p>";
        return $this->errorHandler[404]();
    }

    public function handleError($status, $message): mixed {
        if (isset($this->errorHandler[$status])) {
            return app()->call($this->errorHandler[$status]);
        }

        return $this->errorHandler["default"]($status, $message);
    }

}