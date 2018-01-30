<?php

use core\entities\Recipe\Recipe;
use core\forms\manage\CategoryForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рецепты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить рецепт', Yii::$app->frontendUrlManager->createAbsoluteUrl(['recipes/new']), [
            'class' => 'btn btn-success btn-flat',
            'target' => '_blank'
        ]) ?>
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
                    'attribute' => 'name',
                    'value' => function (Recipe $recipe) {
                        return Html::a(
                            Html::encode($recipe->name),
                            ['view', 'id' => $recipe->id]
                        );
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'name',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/recipe/auto-complete', {
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
                    'value' => function (Recipe $recipe) {
                        return Html::a($recipe->category->name, ['/category/view', 'id' => $recipe->category_id]);
                    },
                    'format' => 'raw',
                    'filter' => CategoryForm::parentCategoriesList(false)
                ],
                [
                    'label' => 'Автор',
                    'attribute' => 'author',
                    'value' => function (Recipe $recipe) {
                        return Html::a(Html::encode($recipe->author->fullName), ['/user/view', 'id' => $recipe->author_id]);
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
                // 'kitchen_id',
                // 'main_photo_id',
                // 'introductory_text:ntext',
                // 'cooking_time:datetime',
                // 'preparation_time:datetime',
                // 'persons',
                // 'complexity',
                // 'notes:ntext',
                'rate',
                // 'comments_count',
                // 'comments_notify',
                // 'created_at',
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
