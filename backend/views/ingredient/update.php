<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\IngredientManageForm */
/* @var $ingredient \core\entities\Ingredient\Ingredient */

$this->title = 'Редактирование ингредиента: ' . $ingredient->title;
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $ingredient->title, 'url' => ['view', 'id' => $ingredient->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="ingredient-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
