<?php

namespace Slimmvc\Database;

use Exception;
use Slimmvc\Database\Connection\Connection;
use Slimmvc\Provider\DatabaseConnectionProvider;

abstract class Model
{
    const DEFAULT_ID_COLUMN = "id";
    const HAS_MANY = "hasMany";
    const HAS_ONE = "hasOne";
    const BELONGS_TO = "belongsTo";

    protected Connection $connection;
    protected string $table;
    protected array $references = [];
    protected array $serializationIgnores = [];
    protected string $idColumn = self::DEFAULT_ID_COLUMN;
    protected array $attributes = [];
    public array $dirty = [];
    protected array $casts = [];

    public function setConnection(Connection $connection): static
    {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection(): Connection
    {
        if (!isset($this->connection)) {
            $this->connection = app(DatabaseConnectionProvider::BEAN_NAME);
        }

        return $this->connection;
    }

    public function getAttributes(array $ignores = []) {
        $result = [];
        foreach ($this->attributes as $key => $value) {
            if (! in_array($key, $ignores)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function toSerializationArray(bool $appliedIgnores = true, int $globalMaxRefDepth = null): array {
        return $this->loadSerializableArrayHelper(1, $globalMaxRefDepth, $appliedIgnores);
    }

    private function loadSerializableArrayHelper(int $currentRefDepth, ?int $globalMaxRefDepth, ?bool $appliedIgnores): array {
        $colAttributes = $this->getAttributes(isset($appliedIgnores) ? $this->serializationIgnores : []);
        $refAttributes = [];

        foreach ($this->references as $attributeName => $config) {
            $maxDepth = isset($globalMaxRefDepth) ? $globalMaxRefDepth : $config["maxRefDepth"];

            if ($currentRefDepth <= $maxDepth) {

                $refData = $this->$attributeName;

                if (is_array($refData)) {
                    $collection = [];
                    foreach ($refData as $refModel) {
                        $collection[] = $refModel->loadSerializableArrayHelper(
                            $currentRefDepth + 1, $globalMaxRefDepth, $appliedIgnores);
                    }

                    $refAttributes[$attributeName] = $collection;
                }
                else if ($refData instanceof Model) {
                    $refAttributes[$attributeName] = $refData->loadSerializableArrayHelper(
                        $currentRefDepth + 1, $globalMaxRefDepth, $appliedIgnores);
                }
                else {
                    $refAttributes[$attributeName] = null;
                }
            }
        }

        return array_merge($colAttributes, $refAttributes);
    }

    public function setIdColumn(string $idColumn) {
        $this->idColumn = $idColumn;
    }

    public function getIdColumn() {
        return $this->idColumn;
    }

    public function setTable(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    public function getTable(): string
    {
        /*if (!isset($this->table)) {
            $reflector = new ReflectionClass(static::class);

            foreach ($reflector->getAttributes() as $attribute) {
                if ($attribute->getName() == TableName::class) {
                    return $attribute->getArguments()[0];
                }
            }

            throw new Exception('$table is not set and getTable is not defined');
        }*/

        if (!isset($this->table)) {
            throw new Exception('$table is not set');
        }

        return $this->table;
    }

    public static function with(array $attributes = []): static
    {
        $model = new static();
        $model->attributes = $attributes;

        return $model;
    }

    public static function query(): mixed
    {
        $model = new static();
        $query = $model->getConnection()->query();

        return (new ModelCollector($query, static::class))
            ->from($model->getTable());
    }

    public static function __callStatic(string $method, array $parameters = []): mixed
    {
        return static::query()->$method(...$parameters);
    }

    public function __get(string $property): mixed
    {
        $getter = 'get' . ucfirst($property) . 'Attribute';

        $value = null;

        if (method_exists($this, $property)) {
            $relationship = $this->$property();
            $method = $relationship->method;

            $value = $relationship->$method();
        }

        if (method_exists($this, $getter)) {
            $value = $this->$getter($this->attributes[$property] ?? null);
        }

        if (isset($this->attributes[$property])) {
            $value = $this->attributes[$property];
        }

        if (!isset($this->attributes[$property]) && isset($this->references[$property])) {
            [
                "relationship" => $relMethod,
                "model" => $refModelClass,
                "foreignKey" => $foreignKey
            ] = $this->references[$property];
            $value = call_user_func([$this, $relMethod], $refModelClass, $foreignKey)();
        }

        if (isset($this->casts[$property]) && is_callable($this->casts[$property])) {
            $value = $this->casts[$property]($value);
        }

        return $value;
    }

    public function __set(string $property, $value)
    {
        $setter = 'set' . ucfirst($property) . 'Attribute';

        array_push($this->dirty, $property);

        if (method_exists($this, $setter)) {
            $this->attributes[$property] = $this->$setter($value);
            return;
        }

        $this->attributes[$property] = $value;
    }

    public function save(): static
    {
        $values = [];

        foreach ($this->dirty as $dirty) {
            $values[$dirty] = $this->attributes[$dirty];
        }

        $data = [array_keys($values), $values];

        $query = static::query();

        $idColumn =$this->getIdColumn();

        if (isset($this->attributes[$idColumn])) {
            $query
                ->where($idColumn, $this->attributes[$idColumn])
                ->update(...$data);

            return $this;
        }

        $query->insert(...$data);

        $this->attributes[$idColumn] = $query->getLastInsertId();
        $this->dirty = [];

        return $this;
    }

    public function delete(): static
    {
        $idColumn = $this->getIdColumn();
        if (isset($this->attributes[$idColumn])) {
            static::query()
                ->where('id', $this->attributes[$idColumn])
                ->delete();
        }

        return $this;
    }

    public function hasOne(string $class, string $foreignKey, string $primaryKey = self::DEFAULT_ID_COLUMN): mixed
    {
        $idColumn = $this->getIdColumn();
        $model = new $class;
        $query = $class::query()->from($model->getTable())->where($foreignKey, $this->attributes[$idColumn]);

        return new Relationship($query, 'first');
    }

    public function hasMany(string $class, string $foreignKey, string $primaryKey = self::DEFAULT_ID_COLUMN): mixed
    {
        $idColumn = $this->getIdColumn();
        $model = new $class;
        $query = $class::query()->from($model->getTable())->where($foreignKey, $this->attributes[$idColumn]);

        return new Relationship($query, 'all');
    }

    public function belongsTo(string $class, string $foreignKey, string $primaryKey = self::DEFAULT_ID_COLUMN): mixed
    {
        $model = new $class;
        $query = $class::query()->from($model->getTable())->where($primaryKey, $this->attributes[$foreignKey]);

        return new Relationship($query, 'first');
    }

    public static function find(int $id, string $idColumn = self::DEFAULT_ID_COLUMN): static
    {
        return static::where($idColumn, $id)->first();
    }
}
