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

        <?= $form->field($model, 'contactEmail')->input('email') ?>

        <?= $form->field($model, 'recipeIntroductoryTextMaxLength')->input('number') ?>

        <?= $form->field($model, 'photoReportText')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'widgetVK')->textarea(['rows' => 4])
                ->hint('<a href="https://vk.com/dev/Community" target="_blank">https://vk.com/dev/Community</a>') ?>

        <?= $form->field($model, 'instagramLogin')->textInput() ?>

        <?= $form->field($model, 'widgetFB')->textarea(['rows' => 4])
                ->hint('<a href="https://developers.facebook.com/docs/plugins/page-plugin" target="_blank">https://developers.facebook.com/docs/plugins/page-plugin</a>') ?>

        <?= $form->field($model, 'bannerSimple1')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerSimple1_show') ?><br><br>

        <?= $form->field($model, 'bannerSimple2')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerSimple2_show') ?><br><br>

        <?= $form->field($model, 'bannerCenterTop')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerCenterTop_show') ?><br><br>

        <?= $form->field($model, 'bannerPagenator')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerPagenator_show') ?><br><br>

        <?= $form->field($model, 'bannerBeforeSteps')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerBeforeSteps_show') ?><br><br>

        <?= $form->field($model, 'bannerDirectUnderMenu')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerDirectUnderMenu_show') ?><br><br>

        <?= $form->field($model, 'bannerDirectAfterCategories')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerDirectAfterCategories_show') ?><br><br>

        <?= $form->field($model, 'bannerFooter')->textarea(['rows' => 4]) ?>
        <?= Html::activeCheckbox($model, 'bannerFooter_show') ?><br><br>

        <?= $form->field($model, 'footer')->textarea(['rows' => 10]) ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
