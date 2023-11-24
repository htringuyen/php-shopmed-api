<?php
namespace Slimmvc\Routing;

use Exception;
use Slimmvc\Provider\HttpRequestProvider;

class Route {
    private string $method;
    private string $path;
    private $handler;
    private array $pathParams = [];
    private ?string $name;
    private bool $protected;
    private mixed $authority;

    public function __construct(string $method, string $path, callable|array $handler,
                                bool $protected = false, mixed $authority = null, $name = null) {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
        $this->name = $name;
        $this->protected = $protected;
        $this->authority = $authority;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPathParams(): array {
        return $this->pathParams;
    }

    public function isProtected(): bool {
        return $this->protected;
    }

    public function getAuthority() {
        return $this->authority;
    }

    public function dispatch() {
        app(HttpRequestProvider::BEAN_NAME)->setRoute($this);

        if (is_array($this->handler)) {

            [$class, $method] = $this->handler;

            if (is_string($class)) {
                $class = new $class;
            }

            return app()->call([$class, $method]);
        }

        return app()->call($this->handler);
    }

    public function matchUrl(string $url): bool {
        $requestPath = parse_url($url, PHP_URL_PATH);

        if (! $this->matchUrlPath($requestPath)) {
            return false;
        }

//        $urlQuery = parse_url($url, PHP_URL_QUERY);
//
//        if (isset($urlQuery)) {
//            $this->requestParams = $this->extractQueryParams($urlQuery);
//        }

        return true;
    }

    private function matchUrlPath(string $path): bool {

        $path = $this->normalisePath($path);

        $pattern = $this->path;
        try {
            $prefix = app("url.path.prefix");
            if (!is_null($prefix)) {
                $pattern = $prefix."/".$pattern;
            }
        }
        catch (Exception $ex) {}
        $pattern = $this->normalisePath($pattern);

        if ($path === $pattern) {
            return true;
        }

        $parameterNames = [];

        $pattern = preg_replace_callback('#{([^}]+)}/#', function (array $found) use (&$parameterNames) {
            array_push($parameterNames, rtrim($found[1], '?'));

            if (str_ends_with($found[1], '?')) {
                return '([^/]*)(?:/?)';
            }

            return '([^/]+)/';
        }, $pattern);

        if (
            !str_contains($pattern, '+')
            && !str_contains($pattern, '*')
        ) {
            return false;
        }

        $path = $this->normalisePath($path);

        preg_match_all("#{$pattern}#", $path, $matches, PREG_SET_ORDER);

        $parameterValues = [];

        if (isset($matches[0][0]) && $matches[0][0] === $path) {
            $matches = $matches[0];

            for ($i=1; $i < count($matches); $i++) {
                $value = $matches[$i];
                if ($value) {
                    array_push($parameterValues, $value);
                }
                else {
                    array_push($parameterValues, "null");
                }
            }

            $emptyValues = array_fill(0, count($parameterNames), false);
            $parameterValues += $emptyValues;

            $this->pathParams = array_combine($parameterNames, $parameterValues);

            return true;
        }

        return false;
    }

//    private function extractQueryParams(string $urlQuery): array {
//        $pattern = "/[&?]([^&?/]+)=([^&]*)/";
//
//        preg_match_all($pattern, $urlQuery, $matches, PREG_SET_ORDER);
//
//        $queryParams = [];
//
//        foreach ($matches as $param) {
//            $queryParams[$param[0]] = $param[1];
//        }
//
//        return $queryParams;
//    }

    private function normalisePath($path): string {
        $path = trim($path, "/");

        $path = "/{$path}/";

        $path = preg_replace("/[\/]{2,}/", "/", $path);

        return $path;
    }
}














