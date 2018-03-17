<?php

use core\entities\Kitchen;
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
        <?= Html::a('Добавить ещё', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'description:html',
                [
                    'label' => 'Картинка',
                    'value' => function(Kitchen $kitchen) {
                        return $kitchen->image ?
                            Html::img($kitchen->getPhotoUrl(true), ['class' => 'img-responsive', 'style' => 'max-height: 300px;'])
                            : 'Без картинки';
                    },
                    'format' => 'raw',
                ],
            ],
        ]) ?>
    </div>
</div>
