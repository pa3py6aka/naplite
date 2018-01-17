<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Kitchen */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Кухни мира', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kitchen-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Вы хорошо подумали?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
            ],
        ]) ?>
    </div>
</div>
