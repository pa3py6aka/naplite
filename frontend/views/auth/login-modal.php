<?php
$model = new \common\forms\LoginForm();

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
                <span class="socials_icons">
						<a href="#"><img src="/img/ico_facebook.png" width="35" height="35" alt=""/></a>
						<a href="#"><img src="/img/ico_vk.png" width="35" height="35" alt=""/></a>
						<a href="#"><img src="/img/ico_twitter.png" width="35" height="35" alt=""/></a>
						<a href="#"><img src="/img/ico_od.png" width="35" height="35" alt=""/></a>
						<a href="#"><img src="/img/ico_yandex.png" width="35" height="35" alt=""/></a>
						<a href="#"><img src="/img/ico_google.png" width="35" height="35" alt=""/></a>
					</span>
                <div class="modals_hr"></div>
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'action' => ['/auth/login'],
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/auth/login-validation'],
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
                                    <?php //= \yii\helpers\Html::activeCheckbox($model, 'rememberMe', ['id' => 'filter_product_country8', 'class' => 'checkbox']) ?>
                                    <label id="filter_product_country_label8" for="filter_product_country8">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Войти</a></button>
                    </div>
                </div>
                <?php \yii\widgets\ActiveForm::end() ?>
                <div class="p40"></div>
                <div class="tac"><a href="javascript:void(0)" class="link_gray f14 forgotPassLink">Забыли пароль?</a></div>
            </div>
        </div>
    </div>
</div>
