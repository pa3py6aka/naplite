<?php

use core\entities\Recipe\Recipe;
use core\helpers\Pluralize;
use core\helpers\RecipeHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \core\entities\Recipe\Recipe */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рецепты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить',  Yii::$app->frontendUrlManager->createAbsoluteUrl(['recipes/edit', 'slug' => $model->slug]), [
            'class' => 'btn btn-primary btn-flat',
            'target' => '_blank',
        ]) ?>
        <?= Html::a('Просмотреть на сайте', Yii::$app->frontendUrlManager->createAbsoluteUrl(['recipes/view', 'slug' => $model->slug]), [
            'class' => 'btn btn-primary btn-flat',
            'target' => '_blank',
        ]) ?>
        &nbsp;
        <?= $model->status == Recipe::STATUS_ACTIVE ?
            Html::a('Заблокировать', ['block', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat',
            ]) :
            Html::a('Опубликовать', ['publish', 'id' => $model->id], [
                'class' => 'btn btn-success btn-flat',
            ]) ?>
        &nbsp;
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Удалить рецепт?',
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
                    'label' => 'Автор',
                    'attribute' => 'author.fullName'
                ],
                [
                    'label' => 'Категория',
                    'value' => function (Recipe $recipe) {
                        $html = [];
                        foreach ($recipe->category->parents as $parent) {
                            if (!$parent->isRoot()) {
                                $html[] = Html::a($parent->name, ['/category/view', 'id' => $parent->id]);
                            }
                        }
                        $html[] = Html::a($recipe->category->name, ['/category/view', 'id' => $recipe->category_id]);
                        return implode(' / ' , $html);
                    },
                    'format' => 'raw'
                ],
                'name',
                [
                    'label' => 'Кухня',
                    'attribute' => 'kitchen.name'
                ],
                [
                    'label' => 'Главное фото',
                    'value' => function (Recipe $recipe) {
                        return Html::img($recipe->mainPhoto, ['class' => 'img-responsive', 'style' => 'height:200px;']);
                    },
                    'format' => 'raw',
                ],
                'introductory_text:html',
                [
                    'label' => 'Время приготовления',
                    'value' => function (Recipe $recipe) {
                        return RecipeHelper::hoursFromMinutes($recipe->cooking_time);
                    },
                ],
                [
                    'label' => 'Время подготовки',
                    'value' => function (Recipe $recipe) {
                        return RecipeHelper::hoursFromMinutes($recipe->preparation_time);
                    },
                ],
                'persons',
                'complexityName',
                'notes:html',
                'rate',
                'comments_count',
                'comments_notify:boolean',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Ингредиенты на <?= Pluralize::get($model->persons, 'персону', 'персоны', 'персон') ?></h3>
            </div>
            <div class="box-body">
                <?php foreach ($model->ingredientSections as $section) {
                    echo Html::tag('strong', Html::encode($section->name)) . '<br />';
                    echo '<ul>';
                    foreach ($section->ingredients as $ingredient): ?>
                        <li><?= $ingredient->name ?>, <?= $ingredient->quantity ?> <?= $ingredient->uom ?></li>
                    <?php endforeach;
                    echo '</ul>';
                } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Праздники</h3>
            </div>
            <div class="box-body">
                <ul>
                    <?php foreach ($model->holidays as $holiday) {
                        echo Html::tag('li', $holiday->name);
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Способ приготовления</h3>
    </div>
    <div class="box-body">
        <table class="table table-stripped">
            <?php foreach ($model->recipeSteps as $step) {
                echo '<tr>';
                echo Html::tag('td', $step->description);
                echo Html::tag('td', $step->photo ?
                    Html::img($step->photoUrl, ['class' => 'img-responsive', 'style' => 'height:200px;']) :
                    ''
                );
                echo '</tr>';
            } ?>
        </table>
    </div>
</div>



