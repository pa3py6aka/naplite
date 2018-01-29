<?php
/* @var $recipeId int */

use core\forms\PhotoReportCreateForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model = new PhotoReportCreateForm();
$model->recipeId = $recipeId;

?>
<div class="modalbox" id="newPhotoReportModal">
    <div class="modal_outer">
        <div class="modal_inner modal_inner_iphone">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Фотоотчёт</h1>
                    <?= Yii::$app->settings->get('photoReportText') ?>
                </div>
                <div class="modals_hr"></div>
                <?php $form = ActiveForm::begin([
                    'action' => ['/photo-reports/create'],
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>

                <?= $form->field($model, 'recipeId')->hiddenInput()->label(false) ?>

                <div class="modal_inputbox">

                    <img class="hidden photo-report-modal-image">
                    <div class="file-upload-block">Добавьте фотографию отчёта</div>

                    <div class="hidden">
                        <?= Html::activeFileInput($model, 'file', ['id' => 'photo-report-file-input']); ?>
                    </div>

                    <div class="radio_and_but">
                        <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Отправить</a></button>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
