<?php

/* @var $this \yii\web\View */
/* @var $model \core\components\Settings\MainSettingsForm */

use core\helpers\CommonVars;
use vova07\imperavi\Widget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "Основные настройки";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'contactEmail')->input('email') ?>

        <?= $form->field($model, 'recipeIntroductoryTextMaxLength')->input('number') ?>

        <?= $form->field($model, 'recipesOnPage')->input('number') ?>
        <?= $form->field($model, 'articlesOnPage')->input('number') ?>
        <?= $form->field($model, 'blogsOnPage')->input('number') ?>
        <?= $form->field($model, 'ingredientsOnPage')->input('number') ?>

        <?= $form->field($model, 'widgetVK')->textarea(['rows' => 4])
                ->hint('<a href="https://vk.com/dev/Community" target="_blank">https://vk.com/dev/Community</a>') ?>

        <?= $form->field($model, 'instagramLogin')->textInput() ?>

        <?= $form->field($model, 'widgetFB')->textarea(['rows' => 4])
                ->hint('<a href="https://developers.facebook.com/docs/plugins/page-plugin" target="_blank">https://developers.facebook.com/docs/plugins/page-plugin</a>') ?>

        <?= $form->field($model, 'footer')->textarea(['rows' => 10]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
