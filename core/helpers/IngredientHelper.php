<?php

namespace core\helpers;


class IngredientHelper
{
    public static function defaultValue($value, $persons)
    {
        if ($persons == 1) {
            return $value;
        }
        $default = round($value / $persons, 2);
        return $default;
    }
}