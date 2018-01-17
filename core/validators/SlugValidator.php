<?php

namespace core\validators;


use yii\validators\RegularExpressionValidator;

class SlugValidator extends RegularExpressionValidator
{
    public $pattern = '#^[a-z0-9_-]*$#s';
    public $message = 'Только [a-z0-9_-] символы допустимы.';
}