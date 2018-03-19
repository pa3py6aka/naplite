<?php
/* @var $this \yii\web\View */
/* @var $value string */
/* @var $mailForm \core\components\Settings\EmailSettingsForm */

use core\helpers\CommonVars;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Настройки email";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">
        <label>Основной шаблон</label>
        <p class="hint">Используется для всех писем. Необходимо чтобы в шаблоне присутствовали маркеры: {TITLE} и {CONTENT}</p>
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
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">
        <?= $form->field($mailForm, 'emailConfirmBody')->widget(\vova07\imperavi\Widget::className(), [
            'id' => 'redactor2',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]) ?>

        <?= $form->field($mailForm, 'passwordResetBody')->widget(\vova07\imperavi\Widget::className(), [
            'id' => 'redactor3',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

