<?php

use core\entities\Blog\Blog;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\Blog\Blog */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;
?>
<div class="blog-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Удалить этот пост?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Автор',
                    'value' => function (Blog $blog) {
                        return Html::a(Html::encode($blog->author->fullName), ['/user/view', 'id' => $blog->author_id]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Категория',
                    'value' => function (Blog $blog) {
                        return Html::a($blog->category->name, ['/blog-category/view', 'id' => $blog->category_id]);
                    },
                    'format' => 'raw',
                ],
                //'title',
                'slug',
                'content:html',
                'views',
                'comments_count',
                'id',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
