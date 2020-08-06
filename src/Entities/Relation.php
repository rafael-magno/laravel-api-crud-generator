<?php

namespace LaravelApiCrudGenerator\Entities;

use LaravelApiCrudGenerator\Traits\MagicGet;

/**
 * @property string $name
 * @property string $type
 * @property string $table
 */
class Relation
{
    use MagicGet;

    private string $name;
    private string $type;
    private string $table;

    public function __construct(
        string $name,
        string $type,
        string $table
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->table = $table;
    }
}