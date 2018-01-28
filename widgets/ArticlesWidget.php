<?php

namespace widgets;


use core\entities\Article\Article;
use yii\base\Widget;

class ArticlesWidget extends Widget
{
    public function run()
    {
        $count = Article::find()->active()->count();
        $offset = mt_rand(0, $count);
        $offset = $offset > $count - 4 ? $count - 4 : $offset;
        $articles = Article::find()
            ->active()
            ->orderBy(['id' => SORT_DESC])
            ->offset($offset)
            ->limit(3)
            ->all();

        return $this->render('articles-block', [
            'articles' => $articles,
        ]);
    }
}