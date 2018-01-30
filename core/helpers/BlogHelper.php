<?php

namespace core\helpers;


use core\entities\Blog\Blog;
use core\repositories\ArticleCategoryRepository;
use core\repositories\BlogRepository;
use yii\helpers\Url;

class BlogHelper
{
    public const USED_ACTIONS = [
        'create',
    ];

    public static function getOptionsWithLinks($for = Blog::class)
    {
        $html = [];
        $categories = $for == Blog::class ? BlogRepository::getCategories() : ArticleCategoryRepository::getCategories();
        $controller = $for == Blog::class ? 'blog' : 'articles';

        foreach ($categories as $category) {
            $html[] = '<option value="' . Url::to(['/' . $controller . '/index', 'category' => $category->slug]) . '">' . $category->name . '</option>';
        }
        return implode("\n", $html);
    }
}