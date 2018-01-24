<?php

namespace widgets;


use core\entities\Article\Article;
use yii\base\Widget;

class ArticlesWidget extends Widget
{
    public function run()
    {
        $articles = Article::find()->active()->orderBy(['id' => SORT_DESC])->limit(3)->all();
        return $this->render('articles-block', [
            'articles' => $articles,
        ]);
    }
}