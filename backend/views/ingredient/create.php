<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \core\forms\manage\IngredientManageForm */

$this->title = 'Новый ингредиент';
$this->params['breadcrumbs'][] = ['label' => 'Ингредиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredient-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
