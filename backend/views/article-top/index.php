<?php

/* @var $topArticles array|\core\entities\Article\ArticleTop[] */

use core\entities\Article\Article;
use core\forms\manage\ArticleCategoryForm;
use core\grid\manage\TopArticlesActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Топ-статьи";

?>
<div class="article-index box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Список топ</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Заголовок</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php $n = 1; ?>
            <?php foreach ($topArticles as $article): ?>
                <tr>
                    <td><?= $n ?></td>
                    <td><?= Html::encode($article->article->title) ?></td>
                    <td>
                        <?php if ($n > 1): ?>
                            <a href="<?= Url::to(['move','d' => 'up', 'id' => $article->id]) ?>" class="btn btn-warning btn-sm btn-flat"><span class="fa fa-sort-up"></span></a>&nbsp;
                        <?php endif; ?>
                        <?php if ($n < count($topArticles)): ?>
                            <a href="<?= Url::to(['move','d' => 'down', 'id' => $article->id]) ?>" class="btn btn-warning btn-sm btn-flat"><span class="fa fa-sort-down"></span></a>&nbsp;
                        <?php endif; ?>
                        <a href="<?= Url::to(['remove', 'id' => $article->id]) ?>" class="btn btn-danger btn-sm btn-flat" data-confirm="Удалить статью из топ-блока?"><span class="fa fa-times"></span></a>&nbsp;
                    </td>
                </tr>
                <?php $n++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="article-index box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Выбор статей</h3>
    </div>
    <div class="box-body table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'label' => 'Заголовок',
                    'attribute' => 'title',
                    'value' => function (Article $article) {
                        return Html::a(
                            Html::encode($article->title),
                            ['view', 'id' => $article->id]
                        );
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'title',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/article/auto-complete', {
                                    value: request.term
                                }, response);
                            }")
                        ],
                        'options' => [
                            'class' => 'form-control',
                        ]
                    ]),
                ],
                [
                    'label' => 'Категория',
                    'attribute' => 'category_id',
                    'value' => function (Article $article) {
                        return Html::a($article->category->name, ['/article-category/view', 'id' => $article->category_id]);
                    },
                    'format' => 'raw',
                    'filter' => ArticleCategoryForm::parentCategoriesList(false)
                ],

                ['class' => TopArticlesActionColumn::class],
            ],
        ]); ?>
    </div>
</div>
