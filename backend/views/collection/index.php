<?php

use core\entities\Recipe\Collection\Collection;
use richardfan\sortable\SortableGridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $collectionsProvider yii\data\ActiveDataProvider */

$this->title = 'Подборки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Создать подборку', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?= SortableGridView::widget([
            'dataProvider' => $collectionsProvider,
            'sortUrl' => Url::to(['sort']),
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'attribute' => 'title',
                    'value' => function (Collection $collection) {
                        return Html::a($collection->title, ['view', 'id' => $collection->id]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Выборка',
                    'value' => function (Collection $collection) {
                        return $collection->category_id ? $collection->category->title : 'Ручная';
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
