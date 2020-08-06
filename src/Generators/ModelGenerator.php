<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;

class ModelGenerator extends Generator
{
    public function __construct(Table $table)
    {
        parent::__construct($table, self::TYPE_MODEL);
    }

    public function handle(): bool
    {
        $relationTypes = array_map(fn($relation) => $relation->type, $this->table->relations);
        $relationTables = array_map(fn($relation) => $relation->table, $this->table->relations);
        $relationUses = array_map(function($tableName) {
            $fileName = $this->getFileName(self::TYPE_MODEL, $tableName);
            $fileName = substr($fileName, 0, -4);
            return str_replace('/', '\\', $fileName);
        }, $relationTables);
        
        return $this->saveFile([
            'table' => $this->table,
            'relationTypes' => array_unique($relationTypes),
            'relationTables' => array_unique($relationTables),
            'namespace' => str_replace('/', '\\', dirname($this->fileName)),
            'relationUses' => $relationUses,
        ]);
    }
}