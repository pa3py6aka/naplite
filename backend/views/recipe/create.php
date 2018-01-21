<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Recipe */

$this->title = 'Create Recipe';
$this->params['breadcrumbs'][] = ['label' => 'Recipes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
