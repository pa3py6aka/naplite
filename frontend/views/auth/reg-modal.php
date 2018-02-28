<?php

use core\forms\auth\SignupForm;
use yii\authclient\widgets\AuthChoice;

$model = new SignupForm();

?>
<div class="modalbox" id="regModal">
    <div class="modal_outer adaptive_message">
        <div class="modal_inner">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Регистрация</h1>
                    Вы можете зарегистрироваться через:
                </div>
                <div class="p20"></div>

                <?= $this->render('@frontend/views/auth/social-block') ?>

                <div class="modals_hr"></div>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'reg-form',
                    'action' => ['/auth/signup'],
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/auth/signup-validation'],
                    'options' => ['data' => ['type' => 'form']]
                ]) ?>
                <div class="modal_inputbox" style="width:86%;">

                    <?= $form->field($model, 'email', ['options' => ['class' => 'inputbox']])
                        ->input('email', ['class' => 'input_base', 'placeholder' => 'Ваш email'])
                        ->label(false) ?>

                    <?= $form->field($model, 'password', ['options' => ['class' => 'inputbox']])
                        ->input('password', ['class' => 'input_base', 'placeholder' => 'Пароль'])
                        ->label(false) ?>

                    <div class="radio_and_but">
                        <button type="submit" class="radio_and_but_right blind-button" data-type="submit-form-link" data-form-id="reg-form">
                            <a type="submit" class="b_red">Зарегистрироваться</a>
                        </button>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="p40"></div>
            </div>
        </div>
    </div>
</div>
