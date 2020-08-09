<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;

class UpdateActionGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'Update' . Str::singularStudly($table->name) . 'Action.php';
        parent::__construct(self::TYPE_UPDATE_ACTION, $fileName, $table);
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