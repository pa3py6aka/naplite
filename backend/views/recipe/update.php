<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Recipe */

$this->title = 'Update Recipe: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recipe-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
