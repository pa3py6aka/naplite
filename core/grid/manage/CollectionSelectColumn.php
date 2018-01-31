<?php

namespace core\grid\manage;


use yii\grid\DataColumn;
use yii\helpers\Html;

class CollectionSelectColumn extends DataColumn
{
    public $collectionId;

    protected function renderDataCellContent($model, $key, $index)
    {
        $isSelected = in_array($this->collectionId, array_keys($model->collectionRecipes));
        $html = Html::a(
            '<span class="fa fa-' . ($isSelected ? 'minus' : 'plus') . '"></span>',
            [$isSelected ? 'un-select' : 'append', 'id' => $model->id, 'collectionId' => $this->collectionId],
            [
                'class' => 'btn btn-xs btn-' . ($isSelected ? 'danger' : 'success') . ' btn-flat',
                'data-method' => 'post'
            ]
        );

        return $html;
    }
}