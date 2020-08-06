<?php

namespace LaravelApiCrudGenerator;

use Illuminate\Support\Str as SupportStr;

class Str extends SupportStr
{
    public static function singularStudly($stringSnakeCase)
    {
        $parts = explode('_', $stringSnakeCase);

        $lastWord = array_pop($parts);

        $stringSnakeCaseSingular = implode('_', $parts) . '_' . self::singular($lastWord);

        return self::studly($stringSnakeCaseSingular);
    }
}