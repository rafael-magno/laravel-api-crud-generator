<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;

class GetActionGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'Get' . Str::singularStudly($table->name) . 'Action.php';
        parent::__construct(self::TYPE_GET_ACTION, $fileName, $table);
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