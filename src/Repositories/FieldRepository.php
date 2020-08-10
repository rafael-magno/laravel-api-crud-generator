<?php

namespace LaravelApiCrudGenerator\Repositories;

use Illuminate\Support\Facades\DB;
use LaravelApiCrudGenerator\Entities\Field;

class FieldRepository
{
    public function getAll(string $table): array
    {
        $fields = DB::select("PRAGMA table_info($table)");

        $except = ['id', 'created_at', 'updated_at'];
        $fields = array_filter($fields, fn($field) => !in_array($field->name, $except));

        $foreignKeys = $this->getForeignKeyFields($table);

        $primaryKeys = array_filter($fields, fn($field) => $field->pk > 0);
        $primaryKeys = array_map(function($field) use($foreignKeys) {
            $field->foreignKeyTable = $foreignKeys[$field->name] ?? null;
            return $field;
        }, $primaryKeys);

        $uniqueFields = $this->getUniqueFields($table);

        $fields = array_map(function($field) use ($uniqueFields, $foreignKeys) {
            return new Field(
                $field->name,
                $field->type,
                $field->notnull == 1,
                in_array($field->name, $uniqueFields),
                $foreignKeys[$field->name] ?? null
            );
        }, $fields);

        return [
            "fields" => $fields,
            "compositePrimaryKeys" => $primaryKeys,
        ];
    }

    private function getUniqueFields(string $table): array
    {
        $indexes = DB::select("PRAGMA index_list($table)");

        $uniqueFields = [];

        foreach ($indexes as $index) {
            if ($index->unique != 1) {
                continue;
            }

            $indexFields = DB::select("PRAGMA index_info({$index->name})");
            if (count($indexFields) == 1) {
                $uniqueFields[] = $indexFields[0]->name;
            }
        }

        return $uniqueFields;
    }

    public function getForeignKeyFields(string $table)
    {
        $foreignKeysList = DB::select("PRAGMA foreign_key_list($table)");

        $foreignKeys = [];

        foreach ($foreignKeysList as $foreignKey) {
            $foreignKeys[$foreignKey->from] = $foreignKey->table;
        }

        return $foreignKeys;
    }
}
