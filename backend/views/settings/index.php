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

        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>

    </div>
    <?php ActiveForm::end() ?>
</div>
