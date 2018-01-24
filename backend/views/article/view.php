<?php

use core\entities\Article\Article;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Article\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Удалить данную статью?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'author_id',
                'category_id',
                [
                    'label' => 'Картинка',
                    'value' => function (Article $article) {
                        return $article->image ?
                            Html::img($article->getImageUrl(true, true), ['class' => 'img-responsive', 'style' => 'height:150px;']) :
                            "Без картинки";
                    },
                    'format' => 'raw',
                ],
                'prev_text:html',
                'content:html',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
