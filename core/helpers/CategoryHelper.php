<?php

namespace core\helpers;


use core\entities\Category;
use yii\helpers\Html;

class CategoryHelper
{
    public static function getBreadCrumbs(Category $category): string
    {
        $html = [];
        foreach ($category->parents as $parent) {
            if (!$parent->isRoot()) {
                $html[] = Html::a($parent->name, $parent->url);
            }
        }
        $html[] = Html::a($category->name, $category->url);
        return implode(' / ' , $html);
    }
}