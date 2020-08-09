<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Utils\Str;

class PaginateRequestGenerator extends Generator
{
    public function __construct()
    {
        parent::__construct(self::TYPE_PAGINATE_REQUEST, 'PaginateRequest.php');
    }

    public function handle(): bool
    {   
        return $this->saveFile([
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceFormRequest' => Str::pathToNamespace(self::getPath(self::TYPE_FORM_REQUEST)),
        ]);
    }
}