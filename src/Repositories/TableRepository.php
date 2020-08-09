<?php

namespace LaravelApiCrudGenerator\Repositories;

use Illuminate\Support\Facades\DB;

class TableRepository
{

    public function getEntities(): array
    {
        $tables = DB::select("
            SELECT 
                name 
            FROM sqlite_master 
            WHERE 
                TYPE = 'table' 
                AND name NOT IN('migrations', 'sqlite_sequence', 'users', 'failed_jobs')
        ");

        dd($tables);
    }
}