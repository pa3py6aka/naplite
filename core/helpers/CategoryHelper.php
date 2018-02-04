<?php

namespace core\helpers;


use core\entities\Article\ArticleCategory;
use core\entities\Ingredient\IngredientCategory;
use core\entities\Recipe\Category;
use yii\helpers\Html;

class CategoryHelper
{
    /**
     * @param Category|ArticleCategory|IngredientCategory $category
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
                    ($parent instanceof ArticleCategory ? Html::a('Статьи', ['/articles/index']) : Html::a('Ингредиенты', ['/ingredients/index']));
            }
        }
        if (!$category->isRoot()) {
            $html[] = Html::a($category->name, $category->url);
        } else {
            $html[] = $category instanceof Category ?
                Html::a('Рецепты', ['/recipes/index']) :
                ($category instanceof ArticleCategory ? Html::a('Статьи', ['/articles/index']) : Html::a('Ингредиенты', ['/ingredients/index']));
        }

        return implode('<span><i class="fa fa-circle"></i></span>' , $html);
    }

    /**
     * Получаем slug активной категории для выделения в главном меню
     * @param Category $category
     * @return string
     */
    public static function getActiveSlug(Category $category): string
    {
        if ($category->depth < 2) {
            return $category->slug;
        }
        foreach ($category->parents as $parent) {
            if ($parent->depth == 1) {
                return $parent->slug;
            }
        }
        return $category->slug;
    }
}