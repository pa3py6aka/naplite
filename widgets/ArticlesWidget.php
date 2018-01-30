<?php

namespace widgets;


use core\entities\Article\Article;
use yii\base\Widget;

class ArticlesWidget extends Widget
{
    public $currentArticleId;

    public function run()
    {
        $count = Article::find()->active()->count();
        $offset = mt_rand(0, $count);
        $offset = $offset > $count - 4 ? $count - 4 : $offset;
        $articles = Article::find()
            ->active()
            ->indexBy('id')
            ->orderBy(['id' => SORT_DESC])
            ->offset($offset)
            ->limit(3)
            ->all();

        if ($this->currentArticleId && isset($articles[$this->currentArticleId])) {
            unset($articles[$this->currentArticleId]);
            $article = Article::find()
                ->active()
                ->where(['not', ['id' => array_merge(array_keys($articles), [$this->currentArticleId])]])
                ->limit(1)
                ->one();
            if ($article) {
                array_push($articles, $article);
            }
        }

        return $this->render('articles-block', [
            'articles' => $articles,
        ]);
    }
}