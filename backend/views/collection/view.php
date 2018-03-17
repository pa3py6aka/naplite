<?php

use core\entities\Recipe\Collection\Collection;
use core\entities\Recipe\Recipe;
use core\forms\manage\CategoryForm;
use core\grid\manage\CollectionSelectColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $collection Collection */
/* @var $selectedRecipesProvider \yii\data\ActiveDataProvider */
/* @var $searchModel backend\forms\RecipeSearch */
/* @var $allRecipesProvider yii\data\ActiveDataProvider */

$this->title = $collection->title;
$this->params['breadcrumbs'][] = ['label' => 'Подборки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $collection->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $collection->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Вы хотите удалить подборку?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Добавить ещё', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $collection,
            'attributes' => [
                //'id',
                //'title',
                //'slug',
                'description:html',
                [
                    'label' => 'Выборка',
                    'value' => function (Collection $collection) {
                        return $collection->category_id ? "Все рецепты из категории &laquo;" .$collection->category->name . "&raquo;"
                            : 'Ручная';
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Картинка',
                    'value' => function (Collection $collection) {
                        return $collection->image ?
                            Html::img($collection->getImageUrl(true, true), ['class' => 'img-responsive', 'style' => 'height:150px;']) :
                            "Без картинки";
                    },
                    'format' => 'raw',
                ],
            ],
        ]) ?>
    </div>
</div>

<?php if (!$collection->category_id): ?>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Выбранные рецепты</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $selectedRecipesProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'label' => 'Название',
                        'attribute' => 'name',
                        'value' => function (Recipe $recipe) {
                            return Html::a(
                                Html::encode($recipe->name),
                                ['/recipe/view', 'id' => $recipe->id]
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => '',
                        'value' => function (Recipe $recipe) use ($collection) {
                            return Html::a(
                                '<span class="fa fa-minus"></span>',
                                ['un-select', 'id' => $recipe->id, 'collectionId' => $collection->id],
                                ['class' => 'btn btn-xs btn-danger btn-flat', 'data-method' => 'post']
                            );
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="box box-primary" id="all-articles">
        <div class="box-header">
            <h3 class="box-title">Все рецепты</h3>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $allRecipesProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'label' => 'Название',
                        'attribute' => 'name',
                        'value' => function (Recipe $recipe) {
                            return Html::a(
                                Html::encode($recipe->name),
                                ['/recipe/view', 'id' => $recipe->id]
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
                    'rate',
                    ['class' => CollectionSelectColumn::class, 'collectionId' => $collection->id],
                ],
            ]); ?>
        </div>
    </div>
<?php endif; ?>
