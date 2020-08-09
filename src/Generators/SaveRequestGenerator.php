<?php

namespace LaravelApiCrudGenerator\Generators;

use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Utils\Str;

class SaveRequestGenerator extends Generator
{
    public function __construct(Table $table)
    {
        $fileName = 'Save' . Str::singularStudly($table->name) . 'Request.php';
        parent::__construct(self::TYPE_SAVE_REQUEST, $fileName, $table);
    }

    public function handle(): bool
    {
        $fieldRules = [];
        $getId = false;

        foreach ($this->table->fields as $field) {
            if ($field->notNull) {
                $fieldRules[$field->name][] = 'required';
            }

            switch ($field->type) {
                case 'integer':
                    $fieldRules[$field->name][] = 'numeric';
                    break;
                case 'date':
                    $fieldRules[$field->name][] = 'date_format:Y-m-d';
                    break;
                case 'datetime':
                    $fieldRules[$field->name][] = 'date_format:Y-m-d H:i:s';
                    break;
            }

            if ($field->foreignKeyTable) {
                $fieldRules[$field->name][] = 'exists:' . $field->foreignKeyTable. ',id';
            }

            if ($field->unique) {
                $fieldRules[$field->name][] = 'unique:' . $this->table->name. ',' . $field->name . ',$id';
                $getId = true;
            }

        }

        return $this->saveFile([
            'table' => $this->table,
            'namespace' => Str::pathToNamespace($this->path),
            'namespaceFormRequest' => Str::pathToNamespace(self::getPath(self::TYPE_FORM_REQUEST)),
            'fieldRules' => $fieldRules,
            'getId' => $getId,
        ]);
    }
}