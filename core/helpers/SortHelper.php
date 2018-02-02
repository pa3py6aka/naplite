<?php

namespace core\helpers;


use yii\data\Sort;

class SortHelper
{
    public static function getUrl(Sort $sort, string $attribute, $desc = true): string
    {
        $url = $sort->createUrl($attribute);
        if ($desc) {
            $url = str_replace('sort=' . $attribute, 'sort=-' . $attribute, $url);
        }
        return $url;
    }
}