<?php

use core\forms\manage\ArticleCategoryForm;
use core\helpers\CommonVars;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ArticleManageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?php //= $form->field($model, 'author_id')->textInput() ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'categoryId')->dropDownList(ArticleCategoryForm::parentCategoriesList()) ?>

        <?= $form->field($model, 'prevText')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'content')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
