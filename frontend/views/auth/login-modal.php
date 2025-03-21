<?php
$model = new \core\forms\auth\LoginForm();

?>
<div class="modalbox" id="loginModal">
    <div class="modal_outer adaptive_message">
        <div class="modal_inner">
            <div class="modal_scroll_box">
                <a href="javascript:void(0)" class="ico_close modalClose"><i class="fa fa-close"></i></a>
                <div class="cb">
                    <h1>Войти</h1>
                    Нет аккаунта? <a href="javascript:void(0)" class="link_red regButton">Зарегистрируйтесь</a> или войдите через:
                </div>
                <div class="p20"></div>

                <?= $this->render('@frontend/views/auth/social-block') ?>

                <div class="modals_hr"></div>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'login-form',
                    'action' => ['/auth/login'],
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/auth/login-validation'],
                    'options' => ['data' => ['type' => 'form']]
                ]); ?>
                <div class="modal_inputbox">

                    <?php echo $form->field($model, 'usernameOrEmail', ['options' => ['class' => 'inputbox']])
                        ->input('email', ['class' => 'input_base', 'placeholder' => 'Ваш логин или email'])
                        ->label(false) ?>

                    <?php echo $form->field($model, 'password', ['options' => ['class' => 'inputbox']])
                        ->input('password', ['class' => 'input_base', 'placeholder' => 'Пароль'])
                        ->label(false) ?>

                    <div class="radio_and_but">
                        <div class="radio_and_but_left">
                            <div class="radiobox_input">
                                <div class="checkbox_outer">
                                    <input type="checkbox" id="filter_product_country8" name="<?= $model->formName() ?>[rememberMe]" value="1" class="checkbox">
                                    <label id="filter_product_country_label8" for="filter_product_country8">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="radio_and_but_right">
                            <a href="javascript:void(0)" class="b_red" data-type="submit-form-link" data-form-id="login-form">Войти</a>
                        </div>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="p40"></div>
                <div class="tac"><a href="javascript:void(0)" class="link_gray f14 forgotPassLink">Забыли пароль?</a></div>
            </div>
        </div>
    </div>
</div>
