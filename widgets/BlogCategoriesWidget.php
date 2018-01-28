<?php

namespace widgets;


use core\repositories\BlogRepository;
use yii\base\Widget;

class BlogCategoriesWidget extends Widget
{
    public $activeCategory = null;

    public function run()
    {
        $categories = BlogRepository::getCategories();
        return $this->render('blog-categories-block', [
            'categories' => $categories,
            'activeCategory' => $this->activeCategory
        ]);
    }
}