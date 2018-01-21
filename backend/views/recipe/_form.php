<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Recipe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'author_id')->textInput() ?>

        <?= $form->field($model, 'category_id')->textInput() ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kitchen_id')->textInput() ?>

        <?= $form->field($model, 'main_photo_id')->textInput() ?>

        <?= $form->field($model, 'introductory_text')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'cooking_time')->textInput() ?>

        <?= $form->field($model, 'preparation_time')->textInput() ?>

        <?= $form->field($model, 'persons')->textInput() ?>

        <?= $form->field($model, 'complexity')->textInput() ?>

        <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
