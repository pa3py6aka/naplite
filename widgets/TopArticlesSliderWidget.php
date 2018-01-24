<?php

namespace widgets;


use core\entities\Article\ArticleTop;
use yii\base\Widget;
use yii\helpers\Html;

class TopArticlesSliderWidget extends Widget
{
    public function run()
    {
        return $this->render('slider-block', ['items' => $this->getItems()]);
    }

    private function getItems()
    {
        $topArticles = ArticleTop::find()
            ->with('article')
            ->orderBy(['sort' => SORT_ASC])
            ->all();

        $items = [];
        foreach ($topArticles as $articleTop) {
            $items[] = [
                'content' => Html::img($articleTop->article->getImageUrl(false)),
                'caption' => Html::encode($articleTop->article->title),
                'options' => []
            ];
        }

        return $items;
    }
}