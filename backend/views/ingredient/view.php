<?php

use core\entities\Ingredient\Ingredient;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Ingredient\Ingredient */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Вы уверены?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'label' => 'Категория',
                    'value' => function (Ingredient $ingredient) {
                        return $ingredient->category->name;
                    },
                ],
                [
                    'label' => 'Картинка',
                    'value' => function (Ingredient $ingredient) {
                        return $ingredient->image ?
                            Html::img($ingredient->getImageUrl(true, true), ['class' => 'img-responsive', 'style' => 'height:150px;']) :
                            "Без картинки";
                    },
                    'format' => 'raw',
                ],
                'prev_text:html',
                'content:html',
            ],
        ]) ?>
    </div>
</div>
