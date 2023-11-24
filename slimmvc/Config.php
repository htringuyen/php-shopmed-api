<?php

namespace Slimmvc;

class Config
{
    const DATABASE = "database";
    const FILESYSTEM = "filesystem";

    public function __construct() {
        $this->loadConfigFor(self::DATABASE);
        $this->loadConfigFor(self::FILESYSTEM);
    }

    private array $loaded = [];

    public function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $file = array_shift($segments);

        if (!isset($this->loaded[$file])) {
            $base = App::getInstance()->resolve('paths.base');
            $separator = DIRECTORY_SEPARATOR;

            $this->loaded[$file] = (array) require "{$base}{$separator}config{$separator}{$file}.php";
        }

        if ($value = $this->withDots($this->loaded[$file], $segments)) {
            return $value;
        }

        return $default;
    }



    private function withDots(array $array, array $segments): mixed
    {
        $current = $array;

        foreach ($segments as $segment) {
            if (!isset($current[$segment])) {
                return null;
            }

            $current = $current[$segment];
        }

        return $current;
    }

    private function loadConfigFor(string $file): void {
        if (!isset($this->loaded[$file])) {
            $base = App::getInstance()->resolve('paths.base');
            $separator = DIRECTORY_SEPARATOR;

            $this->loaded[$file] = (array) require "{$base}{$separator}config{$separator}{$file}.php";
        }
    }
}
