<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\forms\WeightSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weight-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'glass250') ?>

    <?= $form->field($model, 'glass200') ?>

    <?= $form->field($model, 'spoon_big') ?>

    <?php // echo $form->field($model, 'spoon_tea') ?>

    <?php // echo $form->field($model, 'piece') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
