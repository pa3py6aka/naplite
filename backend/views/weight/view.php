<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Weight */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Таблица мер и весов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weight-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Удалить продукт?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить ещё', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'glass250',
                'glass200',
                'spoon_big',
                'spoon_tea',
                'piece',
            ],
        ]) ?>
    </div>
</div>
