<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Utils\Str;

class ListActionGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'List' . Str::studly($table->name) . 'Action.php';
        parent::__construct(self::TYPE_LIST_ACTION, $fileName, $table);
    }

    public function handle(): bool
    {
        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceRepository' => Str::pathToNamespace(self::getPath(self::TYPE_REPOSITORY, $this->table->name)),
            'namespacePaginateRequest' => Str::pathToNamespace(self::getPath(self::TYPE_PAGINATE_REQUEST, $this->table->name)),
        ]);
    }
}