<?php

/* @var $this \yii\web\View */
/* @var $model \core\components\Settings\SettingsForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "Настройки сайта";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'recipeIntroductoryTextMaxLength')->input('number') ?>

        <?= $form->field($model, 'photoReportText')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'widgetVK')->textarea(['rows' => 4])
                ->hint('<a href="https://vk.com/dev/Community" target="_blank">https://vk.com/dev/Community</a>') ?>

        <?= $form->field($model, 'instagramLogin')->textInput() ?>

        <?= $form->field($model, 'widgetFB')->textarea(['rows' => 4])
                ->hint('<a href="https://developers.facebook.com/docs/plugins/page-plugin" target="_blank">https://developers.facebook.com/docs/plugins/page-plugin</a>') ?>

        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>

    </div>
    <?php ActiveForm::end() ?>
</div>
