<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Utils\Str;

class DeleteActionGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'Delete' . Str::singularStudly($table->name) . 'Action.php';
        parent::__construct(self::TYPE_DELETE_ACTION, $fileName, $table);
    }

    public function handle(): bool
    {
        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceRepository' => Str::pathToNamespace(self::getPath(self::TYPE_REPOSITORY, $this->table->name)),
        ]);
    }
}