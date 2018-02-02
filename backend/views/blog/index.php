<?php

use core\entities\Blog\Blog;
use core\entities\Blog\BlogCategory;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить пост', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                    'label' => 'Название',
                    'attribute' => 'title',
                    'value' => function (Blog $blog) {
                        return Html::a(
                            Html::encode($blog->title),
                            ['view', 'id' => $blog->id]
                        );
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'title',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/blog/auto-complete', {
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
                    'value' => function (Blog $blog) {
                        return Html::a($blog->category->name, ['/blog-category/view', 'id' => $blog->category_id]);
                    },
                    'format' => 'raw',
                    'filter' => ArrayHelper::map(BlogCategory::find()->asArray()->all(), 'id', 'name'),
                ],
                [
                    'label' => 'Автор',
                    'attribute' => 'author',
                    'value' => function (Blog $blog) {
                        return Html::a(Html::encode($blog->author->fullName), ['/user/view', 'id' => $blog->author_id]);
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
                //'slug',
                // 'content:ntext',
                // 'views',
                // 'comments_count',
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
                            'autoclose'=>true,
                            'format' => 'dd.mm.yyyy',
                        ],
                    ]),
                    'format' => 'datetime',
                ],
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
