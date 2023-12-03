<?php

namespace Slimmvc\Http;

use Slimmvc\Routing\Route;

class HttpRequest {
    private Route $route;


    public function setRoute(Route $route): void {
        $this->route = $route;
    }

    public function getRoute(): Route {
        return $this->route;
    }


    public function getPath(): string {
        return $this->route->getPath();
    }

    public function getMethod(): string {
        return $this->route->getMethod();
    }


    public function pathVariable(string $key) {
        if (!isset($this->route->getPathParams()[$key])) {
            return null;
        }

        return $this->route->getPathParams()[$key];
    }

    public function requestParam(string $key) {
        if (!isset($_REQUEST[$key])) {
            return null;
        }

        return $_REQUEST[$key];
    }

    public function getContentType() {
        if (!isset($_SERVER["CONTENT_TYPE"])) {
            return null;
        }

        return $_SERVER["CONTENT_TYPE"];
    }

    public function getRawContent() {
        return file_get_contents("php://input");
    }

    public function getBasicAuthorizationHeaderValue(): ?string {
        $authHeader = getallheaders()['Authorization'] ?? null;

        $isMatched = preg_match("/Basic\s(\S+)/", $authHeader, $matches);

        if (isset($authHeader) && $isMatched) {
            return $matches[1];
        }

        return null;
    }

    public function getCookie(string $key): ?string {
        return $_COOKIE[$key] ?? null;
    }
}












