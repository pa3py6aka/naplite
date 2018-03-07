<?php
/* @var $this \yii\web\View */
/* @var $value string */

use core\helpers\CommonVars;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Шаблон для e-mail";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">
        <?= \vova07\imperavi\Widget::widget([
            'id' => 'redactor',
            'value' => $value,
            'name' => 'value',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
