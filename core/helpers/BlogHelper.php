<?php

namespace core\helpers;


use core\entities\Article\Article;
use core\entities\Blog\Blog;
use core\entities\Ingredient\Ingredient;
use core\repositories\ArticleCategoryRepository;
use core\repositories\BlogRepository;
use core\repositories\IngredientCategoryRepository;
use yii\base\InvalidParamException;
use yii\helpers\Url;

class BlogHelper
{
    public const USED_ACTIONS = [
        'create',
    ];

    public static function getOptionsWithLinks($for = Blog::class)
    {
        $html = [];
        if ($for == Blog::class) {
            $categories = BlogRepository::getCategories();
            $controller = 'blog';
        } else if ($for == Article::class) {
            $categories = ArticleCategoryRepository::getCategories();
            $controller = 'articles';
        } else if ($for == Ingredient::class) {
            $categories = IngredientCategoryRepository::getCategories();
            $controller = 'ingredients';
        } else {
            throw new InvalidParamException("Неверное имя класса");
        }

        foreach ($categories as $category) {
            $html[] = '<option value="' . Url::to(['/' . $controller . '/index', 'category' => $category->slug]) . '">' . $category->name . '</option>';
        }
        return implode("\n", $html);
    }
}