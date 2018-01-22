<?php
/* @var $model \core\forms\User\ChangePasswordForm */

?>
<div class="modalbox" id="changePasswordModal">
    <div class="modal_outer adaptive_message">
        <div class="modal_inner">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Установка пароля</h1>
                </div>
                <div class="modals_hr"></div>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/users/change-password-validation'],
                ]) ?>
                <div class="modal_inputbox">

                    <?= $form->field($model, 'oldPassword', ['options' => ['class' => 'inputbox']])
                        ->input('password', ['class' => 'input_base', 'placeholder' => 'Старый пароль'])
                        ->label(false) ?>

                    <?= $form->field($model, 'newPassword', ['options' => ['class' => 'inputbox']])
                        ->input('password', ['class' => 'input_base', 'placeholder' => 'Новый пароль'])
                        ->label(false) ?>

                    <?= $form->field($model, 'confirmPassword', ['options' => ['class' => 'inputbox']])
                        ->input('password', ['class' => 'input_base', 'placeholder' => 'Подтвердите новый пароль'])
                        ->label(false) ?>

                    <div class="radio_and_but">
                        <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Сохранить</a></button>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="p40"></div>
            </div>
        </div>
    </div>
</div>
