<?php

namespace core\grid\manage;


use yii\grid\DataColumn;
use yii\helpers\Html;

class TopArticlesActionColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        $html = Html::a(
            '<span class="fa fa-plus"></span>',
            ['append', 'id' => $model->id],
            ['class' => 'btn btn-sm btn-success btn-flat']
        );

        return $html;
    }
}