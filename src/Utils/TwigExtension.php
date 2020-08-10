<?php

namespace LaravelApiCrudGenerator\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('singularStudly', '\LaravelApiCrudGenerator\Utils\Str::singularStudly'),
            new TwigFilter('singularKebab', '\LaravelApiCrudGenerator\Utils\Str::singularKebab'),
            new TwigFilter('studly', '\LaravelApiCrudGenerator\Utils\Str::studly'),
            new TwigFilter('ucfirst', 'ucfirst'),
        ];
    }
}
