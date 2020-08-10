<?php

namespace LaravelApiCrudGenerator\Repositories;

use Illuminate\Support\Facades\DB;
use LaravelApiCrudGenerator\Entities\Table;

class TableRepository
{
    private $relationRepository;
    private $fieldRepository;

    public function __construct(RelationRepository $relationRepository, FieldRepository $fieldRepository)
    {
        $this->relationRepository = $relationRepository;
        $this->fieldRepository = $fieldRepository;
    }

    public function getEntities()
    {
        $resultTables = DB::select("
            SELECT
                name
            FROM sqlite_master
            WHERE
                TYPE = 'table'
                AND name NOT IN('migrations', 'sqlite_sequence', 'failed_jobs')
        ");

        $tableFields = [];
        $mapRelations = [];

        foreach ($resultTables as $table) {
            $fieldData = $this->fieldRepository->getAll($table->name);

            if (!in_array(count($fieldData['compositePrimaryKeys']), [0, 2])) {
                continue;
            } else if (!empty($fieldData['compositePrimaryKeys'])) {
                $table1 = $fieldData['compositePrimaryKeys'][0]->foreignKeyTable;
                $table2 = $fieldData['compositePrimaryKeys'][1]->foreignKeyTable;

                if (!$table1 || !$table2) {
                    continue;
                }

                $mapRelations[$table1][$table2]['N'][] = 'belongsToMany';
                $mapRelations[$table2][$table1]['N'][] = 'belongsToMany';

                continue;
            }
            $foreignKeyFields = array_filter($fieldData['fields'], fn($field) => $field->foreignKeyTable);

            foreach ($foreignKeyFields as $field) {
                $mapRelations[$table->name][$field->foreignKeyTable]['1'][] = 'belongsTo';
                if ($field->unique) {
                    $mapRelations[$field->foreignKeyTable][$table->name]['1'][] = 'hasOne';
                } else {
                    $mapRelations[$field->foreignKeyTable][$table->name]['N'][] = 'hasMany';
                }
            }

            $tableFields[$table->name] = $fieldData['fields'];
        }

        $tables = [];

        foreach ($tableFields as $tableName => $fields) {
            $relations = [];
            if (isset($mapRelations[$tableName])) {
                $relations = $this->relationRepository->getRelations($mapRelations[$tableName]);
            }

            $tables[] = new Table($tableName, $relations, $fields);
        }

        return $tables;
    }
}
