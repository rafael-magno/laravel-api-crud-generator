<?php

use LaravelApiCrudGenerator\Commands\CrudGenerateCommand;

require __DIR__.'/vendor/autoload.php';

$config = require __DIR__.'/src/resources/config/crudGenerator.php';

function config($name) {
    global $config;

    $names = explode('.', $name);
    unset($names[0]);
    $configValue = "";
    eval('$configValue = $config["'.implode('"]["', $names).'"];');
    
    return $configValue;
}

$crudGenerateCommand = new CrudGenerateCommand();
$crudGenerateCommand->handle();