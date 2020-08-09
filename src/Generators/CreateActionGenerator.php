<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Utils\Str;

class CreateActionGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'Create' . Str::singularStudly($table->name) . 'Action.php';
        parent::__construct(self::TYPE_CREATE_ACTION, $fileName, $table);
    }

    public function handle(): bool
    {
        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceRepository' => Str::pathToNamespace(self::getPath(self::TYPE_REPOSITORY, $this->table->name)),
            'namespaceSaveRequest' => Str::pathToNamespace(self::getPath(self::TYPE_SAVE_REQUEST, $this->table->name)),
        ]);
    }
}