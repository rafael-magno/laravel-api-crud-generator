<?php

namespace LaravelApiCrudGenerator\Repositories;

use LaravelApiCrudGenerator\Entities\Relation;
use LaravelApiCrudGenerator\Utils\Str;

class RelationRepository
{
    public function getRelations(array $relationsArray): array
    {
        $relations = [];

        foreach ($relationsArray as $tableName => $relationsTable) {
            foreach ($relationsTable as $numberHas => $relationsOrder) {
                foreach ($relationsOrder as $i => $relationType) {
                    $relationName = $numberHas == 'N' ? Str::camel($tableName) : Str::singularCamel($tableName);
                    $relationName .= $i ? $i : '';
                    $relations[] = new Relation($relationName, $relationType, $tableName);
                }
            }
        }

        return $relations;
    }
}
