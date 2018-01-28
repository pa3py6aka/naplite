<?php

namespace core\helpers;


use core\repositories\BlogRepository;
use yii\helpers\Url;

class BlogHelper
{
    public const USED_ACTIONS = [
        'create',
    ];

    public static function getOptionsWithLinks()
    {
        $html = [];
        foreach (BlogRepository::getCategories() as $category) {
            $html[] = '<option value="' . Url::to(['/blog/index', 'slug' => $category->slug]) . '">' . $category->name . '</option>';
        }
        return implode("\n", $html);
    }
}