<?php

namespace LaravelApiCrudGenerator\Entities;

use LaravelApiCrudGenerator\Traits\MagicGet;

/**
 * @property string $name
 * @property Relation[] $relations
 * @property Field[] $fields
 */
class Table
{
    use MagicGet;

    private string $name;
    private array $relations;
    private array $fields;

    public function __construct(
        string $name, 
        array $relations, 
        array $fields
    ) {
        $this->name = $name;
        $this->relations = $relations;
        $this->fields = $fields;
    }
}