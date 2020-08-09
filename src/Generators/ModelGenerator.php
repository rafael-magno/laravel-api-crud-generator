<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Utils\Str;

class ModelGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = Str::singularStudly($table->name) . '.php';
        parent::__construct(self::TYPE_MODEL, $fileName, $table);
    }

    public function handle(): bool
    {
        $relationTypes = array_map(fn($relation) => $relation->type, $this->table->relations);
        $relationTables = array_map(fn($relation) => $relation->table, $this->table->relations);
        $relationUses = array_map(function($tableName) {
            $fullFileName = self::getPath(self::TYPE_MODEL, $tableName);
            $fullFileName .= '/' . Str::singularStudly($tableName);
            return Str::pathToNamespace($fullFileName);
        }, $relationTables);
        
        return $this->saveFile([
            'table' => $this->table,
            'relationTypes' => array_unique($relationTypes),
            'relationTables' => array_unique($relationTables),
            'namespace' => Str::pathToNamespace($this->path),
            'relationUses' => $relationUses,
        ]);
    }
}