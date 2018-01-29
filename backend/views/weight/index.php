<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\WeightSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Таблица мер и весов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weight-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить продукт', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name',
                'glass250',
                'glass200',
                'spoon_big',
                'spoon_tea',
                'piece',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
