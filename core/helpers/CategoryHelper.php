<?php

namespace core\helpers;


use core\entities\Article\ArticleCategory;
use core\entities\Category;
use yii\helpers\Html;

class CategoryHelper
{
    /**
     * @param Category|ArticleCategory $category
     * @return string
     */
    public static function getBreadCrumbs($category): string
    {
        $html[] = '<a href="/">Главная</a>';
        foreach ($category->parents as $parent) {
            if (!$parent->isRoot()) {
                $html[] = Html::a($parent->name, $parent->url);
            } else {
                $html[] = $parent instanceof Category ?
                    Html::a('Рецепты', ['/recipes/index']) :
                    Html::a('Статьи', ['/articles/index']);
            }
        }
        if (!$category->isRoot()) {
            $html[] = Html::a($category->name, $category->url);
        } else {
            $html[] = $category instanceof Category ?
                Html::a('Рецепты', ['/recipes/index']) :
                Html::a('Статьи', ['/articles/index']);
        }

        return implode(' / ' , $html);
    }
}