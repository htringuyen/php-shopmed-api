<?php

namespace Slimmvc\Http;

use InvalidArgumentException;

class HttpResponse {
    const REDIRECT = 'REDIRECT';
    const HTML = 'HTML';
    const JSON = 'JSON';
    const CSS = 'CSS';
    const JS = 'JS';
    const IMAGE = "IMAGE";
    const JPEG = 'JPEG';
    const PNG = 'PNG';

    const HEADER_CONTENT_TYPE = "Content-Type";
    const HEADER_CONTENT_LENGTH = "Content-Length";
    const HEADER_LOCATION = "Location";

    private string $type = HttpResponse::HTML;

    private mixed $content = '';
    private int $status = 200;
    private array $headers = [];


    public function send(): void
    {
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }

        if ($this->type === static::HTML) {
            header('Content-Type: text/html');
            http_response_code($this->status);
            print $this->content;
            return;
        }

        if ($this->type === static::JSON) {
            header('Content-Type: application/json');
            http_response_code($this->status);
            print json_encode($this->content);
            return;
        }


        if ($this->type === static::REDIRECT) {
            return;
        }

        if ($this->type === static::CSS) {
            header('Content-Type: text/css');
            http_response_code($this->status);
            print $this->content;
            return;
        }

        if ($this->type === static::JS) {
            header('Content-Type: text/javascript');
            http_response_code($this->status);
            print $this->content;
            return;
        }

        if ($this->type === static::JPEG) {
            header('Content-Type: image/jpeg');
            http_response_code($this->status);
            if (is_resource($this->getContent())) {
                fpassthru($this->getContent());
                return;
            }
            return;
        }

        if ($this->type === static::IMAGE) {
            http_response_code($this->status);
            if (is_resource($this->getContent())) {
                fpassthru($this->getContent());
                return;
            }
            return;
        }

        if ($this->type === static::PNG) {
            header('Content-Type: image/png');
            http_response_code($this->status);
            if (is_resource($this->getContent())) {
                fpassthru($this->getContent());
                return;
            }
            return;
        }

        throw new InvalidArgumentException("{$this->type} is not a recognised type");
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function setContent(mixed $content): void
    {
        $this->content = $content;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function addHeaders(array $headers): void {
        foreach ($headers as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }


}