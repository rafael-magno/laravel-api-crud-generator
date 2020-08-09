<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;

class RepositoryGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = Str::singularStudly($table->name) . 'Repository.php';
        parent::__construct(self::TYPE_REPOSITORY, $fileName, $table);
    }

    public function handle(): bool
    {
        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceBaseRepository' => Str::pathToNamespace(self::getPath(self::TYPE_BASE_REPOSITORY)),
            'namespaceModel' => Str::pathToNamespace(self::getPath(self::TYPE_MODEL, $this->table->name)),
        ]);
    }
}