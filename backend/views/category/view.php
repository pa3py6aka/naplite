<?php

use core\entities\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $category core\entities\Category */

$this->title = $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                    'title',
                    'description:ntext',
                    //'seo_text:ntext',
                    [
                        'label' => 'Иконка',
                        'value' => function (Category $category) {
                            $result = '';
                            if (!$category->getIcon(true)) {
                                $result = "Без иконки, родительская иконка:<br>";
                            }
                            return $result . Html::img($category->getIcon(), ['class' => 'img-responsive', 'style' => 'height:40px;']);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Картинка',
                        'value' => function (Category $category) {
                            return $category->getImageUrl(true) ?
                                Html::img($category->imageUrl, ['class' => 'img-responsive', 'style' => 'height:150px;']) :
                                "Без картинки";
                        },
                        'format' => 'raw',
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>