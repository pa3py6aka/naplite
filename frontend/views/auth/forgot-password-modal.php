<?php
$model = new \frontend\forms\auth\PasswordResetRequestForm();

?>
<div class="modalbox" id="forgotPasswordModal">
    <div class="modal_outer adaptive_message">
        <div class="modal_inner">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Забыли пароль?</h1>
                    Введите e-mail указанный при регистрации
                </div>
                <div class="modals_hr"></div>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['/auth/request-password-reset'],
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/auth/request-password-reset-validation'],
                ]) ?>
                <div class="modal_inputbox">

                    <?= $form->field($model, 'email', ['options' => ['class' => 'inputbox']])
                        ->input('email', ['class' => 'input_base', 'placeholder' => 'Ваш email'])
                        ->label(false) ?>

                    <div class="radio_and_but">
                        <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Восстановить</a></button>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="p40"></div>
            </div>
        </div>
    </div>
</div>
