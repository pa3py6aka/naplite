<?php

use core\entities\Article\Article;
use core\forms\manage\ArticleCategoryForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить статью', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
                    'label' => 'Автор',
                    'attribute' => 'author',
                    'value' => function (Article $article) {
                        return Html::a($article->author->fullName, ['/user/view', 'id' => $article->author_id]);
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'author',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/user/auto-complete', {
                                    username: request.term
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
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'attribute2' => 'date_to',
                        'type' => DatePicker::TYPE_RANGE,
                        'separator' => '-',
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ],
                    ]),
                    'format' => 'datetime',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
