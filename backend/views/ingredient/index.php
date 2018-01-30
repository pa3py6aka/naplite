<?php

use core\entities\Ingredient\Ingredient;
use core\forms\manage\IngredientCategoryForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\IngredientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ингредиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('Добавить ингредиент', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                [
                    'label' => 'Заголовок',
                    'attribute' => 'title',
                    'value' => function (Ingredient $ingredient) {
                        return Html::a(
                            Html::encode($ingredient->title),
                            ['view', 'id' => $ingredient->id]
                        );
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Категория',
                    'attribute' => 'category_id',
                    'value' => function (Ingredient $ingredient) {
                        return Html::a($ingredient->category->name, ['/ingredient-category/view', 'id' => $ingredient->category_id]);
                    },
                    'format' => 'raw',
                    'filter' => IngredientCategoryForm::parentCategoriesList(false)
                ],
                //'prev_text:ntext',
                //'content:ntext',
                // 'image',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
