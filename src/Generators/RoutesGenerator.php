<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Str;

class RoutesGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'routes.php';
        parent::__construct(self::TYPE_ROUTES, $fileName, $table);
    }

    public function handle(): bool
    {
        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceCreateAction' => Str::pathToNamespace(self::getPath(self::TYPE_CREATE_ACTION, $this->table->name)),
            'namespaceGetAction' => Str::pathToNamespace(self::getPath(self::TYPE_GET_ACTION, $this->table->name)),
            'namespaceListAction' => Str::pathToNamespace(self::getPath(self::TYPE_LIST_ACTION, $this->table->name)),
            'namespaceUpdateAction' => Str::pathToNamespace(self::getPath(self::TYPE_UPDATE_ACTION, $this->table->name)),
            'namespaceDeleteAction' => Str::pathToNamespace(self::getPath(self::TYPE_DELETE_ACTION, $this->table->name)),
        ]);
    }
}