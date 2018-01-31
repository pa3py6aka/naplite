<?php
namespace core\grid\manage;


use yii\grid\DataColumn;
use yii\helpers\Html;

class CollectionActionsColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $buttons = [];
        $buttons[] = Html::a($model->status ? 'Не показывать' : 'Показывать', [
            'set-status',
            'id' => $model->id,
            'to' => $model->status ? 0 : 1
        ], ['class' => 'btn btn-sm btn-flat btn-' . ($model->status ? 'warning' : 'success'), 'data-method' => 'post']);

        $buttons[] = Html::a('<span class="fa fa-edit"></span>', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-flat btn-primary']);
        $buttons[] = Html::a('<span class="fa fa-remove"></span>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-flat btn-danger',
            'data' => [
                'confirm' => 'Вы хотите удалить эту подборку?',
                'method' => 'post'
            ]
        ]);

        return implode(" ", $buttons);
    }
}