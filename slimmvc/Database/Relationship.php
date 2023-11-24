<?php

namespace Slimmvc\Database;

use PDOException;
use Slimmvc\Database\ModelCollector;

class Relationship
{
    public ModelCollector $collector;
    public string $method;

    public function __construct(ModelCollector $collector, string $method)
    {
        $this->collector = $collector;
        $this->method = $method;
    }

    public function __invoke(array $parameters = []): mixed
    {
        $method = $this->method;

        try {
            return $this->collector->$method(...$parameters);
        }
        catch (PDOException $ex) {
            return null;
        }

    }

    public function __call(string $method, array $parameters = []): mixed
    {
        return $this->collector->$method(...$parameters);
    }
}
