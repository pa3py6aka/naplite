<?php
/* @var $this \yii\web\View */
/* @var $value string */
/* @var $model \core\components\Settings\NotificationsSettingsForm */

use core\helpers\CommonVars;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Уведомления";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">
        <?= $form->field($model, 'emptyBlockForCookbook')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'emptyBlockForRecipes')->widget(Widget::className(), [
            'id' => 'redactor2',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'emptyBlockForPosts')->widget(Widget::className(), [
            'id' => 'redactor3',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'emptyBlockForPhotos')->widget(Widget::className(), [
            'id' => 'redactor4',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'signupOkMessage')->widget(Widget::className(), [
            'id' => 'redactor5',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'signupConfirmMessage')->widget(Widget::className(), [
            'id' => 'redactor5',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'photoReportAddedMessage')->widget(Widget::className(), [
            'id' => 'redactor6',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?= $form->field($model, 'photoReportText')->widget(Widget::className(), [
            'id' => 'redactor7',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

