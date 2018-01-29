<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Weight */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weight-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'glass250')->textInput() ?>

        <?= $form->field($model, 'glass200')->textInput() ?>

        <?= $form->field($model, 'spoon_big')->textInput() ?>

        <?= $form->field($model, 'spoon_tea')->textInput() ?>

        <?= $form->field($model, 'piece')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
