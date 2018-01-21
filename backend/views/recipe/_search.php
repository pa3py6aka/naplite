<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\forms\RecipeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'kitchen_id') ?>

    <?php // echo $form->field($model, 'main_photo_id') ?>

    <?php // echo $form->field($model, 'introductory_text') ?>

    <?php // echo $form->field($model, 'cooking_time') ?>

    <?php // echo $form->field($model, 'preparation_time') ?>

    <?php // echo $form->field($model, 'persons') ?>

    <?php // echo $form->field($model, 'complexity') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'comments_count') ?>

    <?php // echo $form->field($model, 'comments_notify') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
