<?php

namespace widgets;


use yii\base\Widget;

class ArticlesWidget extends Widget
{
    public function run()
    {
        return $this->render('articles-block');
    }
}