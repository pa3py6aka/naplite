<?php

/* @var $this \yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $model \core\forms\User\UserSettingsForm */
/* @var $changePasswordModel \core\forms\User\ChangePasswordForm */

use core\entities\User\Country;
use widgets\BannerWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Настройки аккаунта";

?>
<div class="content_left" id="userSettingsPage">
    <div class="blog_adaptive_menu">
        <div class="blog_adaptive_menu_left">
            <select class="select_base" name="sdfgerg">
                <option value="1">Настройки</option>
            </select>
        </div>
    </div>
    <div class="textbox_nop">
        <div class="userpage_info">
            <div class="userpage_info_left">
                <div class="userpage_info_left_inner">
                    <div class="userpage_info_left_inner_left">
                        <div class="cb"><h1>Настройки</h1></div>
                        <?php $form = ActiveForm::begin([
                            'id' => 'userSettingsForm',
                            'options' => ['enctype' => 'multipart/form-data', 'data' => ['type' => 'form']],
                        ]) ?>
                            <div class="userpage_userpickbox_adaptive">
                                <div class="cb">
                                    <a href="javascript:void(0)" data-link="choose-avatar-link">
                                        <img src="<?= $user->avatarUrl ?>" width="200" height="200" alt="" data-image="avatar"/>
                                        <?= Html::activeFileInput($model, 'avatar', ['class' => 'hidden upload-file', 'accept' => 'image/*']) ?>
                                    </a>
                                </div>
                                <div class="p20"></div>
                                <?php if (!$user->avatar): ?>
                                <div class="cb hint tacimp lh22">
                                    Загрузите свою фотографию, <br />
                                    чтобы пользователи узнавали <br />
                                    вас, так удобнее общаться!<br /><br />
                                </div>
                                <?php endif; ?>
                                <div class="cb">
                                    <a href="javascript:void(0)" class="b_gray" data-link="choose-avatar-link"><i class="fa fa-photo"></i>
                                        <?= !$user->avatar ? 'Загрузить' : 'Изменить' ?> своё фото
                                    </a>
                                </div>
                                <div class="p40"></div>
                            </div>
                            <div class="inputbox">
                                <div class="inputbox_label">Ваше имя на сайте:</div>
                                <?= $form->field($model, 'username', ['options' => ['class' => 'inputbox_input']])
                                    ->textInput(['class' => 'input_base'])
                                    ->label(false) ?>
                            </div>
                            <div class="inputbox">
                                <div class="inputbox_label">Email:</div>
                                <?= $form->field($model, 'email', ['options' => ['class' => 'inputbox_input']])
                                    ->input('email', ['class' => 'input_base'])
                                    ->label(false) ?>
                            </div>
                            <div class="inputbox">
                                <a href="javascript:void(0)" class="link_gray" data-link="change-password">Изменить свой пароль</a>
                            </div>
                            <div class="hr"></div>
                            <div class="inputbox">
                                <div class="inputbox_label">Откуда вы:</div>
                                <?= $form->field($model, 'country', ['options' => ['class' => 'inputbox_input']])
                                    ->dropDownList(ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name'), ['class' => 'select_base', 'prompt' => 'Выберите страну'])
                                    ->label(false) ?>
                                <div class="p10"></div>
                                <?= $form->field($model, 'city', ['options' => ['class' => 'inputbox_input']])
                                    ->textInput(['class' => 'input_base', 'placeholder' => 'Укажите город'])
                                    ->label(false) ?>
                                <!--<div class="inputbox_input">
                                    <select name="sdfgwegsdf" class="select_base">
                                        <option value="2">Санкт-Петербург</option>
                                    </select>
                                </div>-->
                                <div class="p40"></div>
                                <div class="inputbox">
                                    <div class="inputbox_label">
                                        <div class="inputbox_label_2col">
                                            <div class="inputbox_label_left">Несколько слов о вас:</div>
                                            <div class="inputbox_label_right"><img src="/img/wsw.jpg" width="155" height="19" alt=""/></div>
                                        </div>
                                    </div>
                                    <?= $form->field($model, 'about', ['options' => ['class' => 'inputbox_input']])
                                        ->textarea(['class' => 'textarea_base',
                                            'placeholder' => 'Напишите пару предложений о вас',
                                            'cols' => 2,
                                            'rows' => 2
                                        ])
                                        ->label(false) ?>
                                </div>
                                <div class="cb">
                                    <div class="radiobox_input">
                                        <input type="hidden" name="<?= $model->formName() ?>[subscribeCommentsNotify]" value="0">
                                        <div class="checkbox_outer">
                                            <input type="checkbox" id="subscribeCommentsNotify" name="<?= $model->formName() ?>[subscribeCommentsNotify]" value="1" class="checkbox"<?= $model->subscribeCommentsNotify ? ' checked' : '' ?>>
                                            <label id="subscribeCommentsNotifyLabel" for="subscribeCommentsNotify">
                                                Получать комментарии к рецепту на почту
                                            </label>
                                        </div>
                                    </div>
                                    <div class="p10"></div>
                                    <div class="radiobox_input">
                                        <input type="hidden" name="<?= $model->formName() ?>[subscribeHolidays]" value="0">
                                        <div class="checkbox_outer">
                                            <input type="checkbox" id="subscribeHolidays" name="<?= $model->formName() ?>[subscribeHolidays]" value="1" class="checkbox"<?= $model->subscribeHolidays ? ' checked' : '' ?>>
                                            <label id="subscribeHolidaysLabel" for="subscribeHolidays">
                                                Получать интересные рецепты перед праздниками
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end() ?>
                    </div>
                    <div class="userpage_info_left_inner_right tacimp">
                        <div class="userpage_userpickbox">
                            <div class="cb">
                                <a href="javascript:void(0)" data-link="choose-avatar-link">
                                    <img src="<?= $user->avatarUrl ?>" width="200" height="200" alt="" data-image="avatar"/>
                                </a>
                            </div>
                            <div class="p20"></div>
                            <?php if (!$user->avatar): ?>
                            <div class="cb hint tacimp lh22">
                                Загрузите свою фотографию, <br />
                                чтобы пользователи узнавали <br />
                                вас, так удобнее общаться!<br /><br />
                            </div>
                            <?php endif; ?>
                            <div class="cb">
                                <a href="javascript:void(0)" class="b_gray" data-link="choose-avatar-link"><i class="fa fa-photo"></i>
                                    <?= !$user->avatar ? 'Загрузить' : 'Изменить' ?> своё фото
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add_recipe_bottom">
                    <a href="javascript:void(0)" class="b_red" data-type="submit-form-link" data-form-id="userSettingsForm"><i class="fa fa-save"></i>Сохранить изменения</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content_right">
    <div class="right_menu">
        <ul>
            <li><a href="<?= $user->pageUrl ?>">Личная страница</a></li>
            <li><a href="#">Кулинарная книга</a></li>
            <!-- ToDo : Личные сообщения
            <li><a href="#">Сообщения</a></li>-->
            <li><a href="#">Мои рецепты</a></li>
            <li><a href="#">Мои посты</a></li>
            <li><a href="#">Мои фотоотчеты</a></li>
            <li><a href="javascript:void(0)" class="right_menu_active">Настройки</a></li>
        </ul>
    </div>
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>
</div>

<?= $this->render('change-password-modal', ['model' => $changePasswordModel]) ?>
