<?php

namespace LaravelApiCrudGenerator;

use Illuminate\Console\Command;
use LaravelApiCrudGenerator\Entities\Field;
use LaravelApiCrudGenerator\Entities\Relation;
use LaravelApiCrudGenerator\Entities\Table;
use LaravelApiCrudGenerator\Generators\ModelGenerator;

class CrudGenerateCommand extends Command
{
    protected $name = 'make:crud';
    protected $description = 'Generate API CRUD.';

    public function handle()
    {
        $tables = $this->getTables();

        // FormRequestGenerator
        // PaginateRequestGenerator
        foreach ($tables as $table) {
            // ModelGenerator
            ModelGenerator::generate($table);
            // RepositoryGenerator
            // SaveRequestGenerator
            // ListRequestGenerator
            // CreateActionGenerator
            // GetActionGenerator
            // ListActionGenerator
            // UpdateActionGenerator
            // DeleteActionGenerator
        }
        //$this->info("CRUD created successfully.");
    }

    private function getTables(): array
    {
        return [
            new Table(
                'users',
                [],
                [
                    new Field('name', 'varchar', true, false),
                    new Field('email', 'varchar', true, true),
                    new Field('email_verified_at', 'datetime', false, false),
                    new Field('password', 'varchar', true, false),
                    new Field('remember_token', 'varchar', false, false),
                ]
            ),
            new Table(
                'students',
                [
                    new Relation('shift', 'belongsTo', 'shifts'),
                    new Relation('subjects', 'belongsToMany', 'subjects'),
                ],
                [
                    new Field('name', 'varchar', true, false),
                    new Field('shift_id', 'integer', true, false),
                ]
            ),
            new Table(
                'shifts',
                [
                    new Relation('students', 'hasMany', 'students'),
                ],
                [
                    new Field('name', 'varchar', true, true),
                ]
            ),
            new Table(
                'subjects',
                [
                    new Relation('students', 'belongsToMany', 'students'),
                ],
                [
                    new Field('name', 'varchar', true, true),
                ]
            ),
        ];
    }
}
