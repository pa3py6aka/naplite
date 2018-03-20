<?php
/* @var $this \yii\web\View */
/* @var $value string */
/* @var $model \core\components\Settings\BannerSettingsForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Настройки баннеров";

?>
<div class="box box-primary">
    <?php $form = ActiveForm::begin() ?>
    <div class="box-body table-responsive">
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
    </div>
    <div class="box-footer">
        <?= Html::submitButton("Сохранить", ['class' => 'btn btn-flat btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

