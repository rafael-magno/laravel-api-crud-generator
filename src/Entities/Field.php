<?php

namespace LaravelApiCrudGenerator\Entities;

use Exception;
use LaravelApiCrudGenerator\Traits\MagicGet;

/**
 * @property string $name
 * @property string $type
 * @property bool $notNull
 * @property bool $unique
 * @property ?string $foreignKeyTable
 */
class Field
{
    use MagicGet;

    private string $name;
    private string $type;
    private bool $notNull;
    private bool $unique;
    private ?string $foreignKeyTable;

    public function __construct(
        string $name,
        string $type,
        bool $notNull,
        bool $unique,
        ?string $foreignKeyTable = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->notNull = $notNull;
        $this->unique = $unique;
        $this->foreignKeyTable = $foreignKeyTable;
    }
}