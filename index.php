<?php

use LaravelApiCrudGenerator\CrudGenerateCommand;

require __DIR__.'/vendor/autoload.php';

$crudGenerateCommand = new CrudGenerateCommand();
$crudGenerateCommand->handle();