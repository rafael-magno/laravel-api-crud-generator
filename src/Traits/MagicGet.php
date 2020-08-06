<?php

namespace LaravelApiCrudGenerator\Traits;

use Exception;

trait MagicGet
{
    public function __get(string $property)
    {
        if (!$this->__isset($property)) {
            throw new Exception("Invalid property!");
        }

        return $this->$property;
    }

    public function __isset(string $property)
    {
        return property_exists($this, $property);
    }
}