<?php

use core\forms\manage\CategoryForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\CollectionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

        <?= $form->field($model, 'categoryId')
            ->dropDownList(CategoryForm::parentCategoriesList(false), ['prompt' => 'Без раздела']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
