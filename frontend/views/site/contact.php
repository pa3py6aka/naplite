<?php

use widgets\BannerWidget;
use widgets\RecipeThemesWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\ContactForm */

$this->title = 'Связь с администрацией сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="/">Главная</a>
            </div>
            <h1><?= $this->title ?></h1>
        </div>
        <div class="form_center">
            <div class="row">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Ваш e-mail:</div>
                        </div>
                    </div>
                    <?= $form->field($model, 'email')
                        ->input('email', ['autofocus' => true, 'class' => 'input_base'])->label(false) ?>
                </div>

                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Ваше имя:</div>
                        </div>
                    </div>
                    <?= $form->field($model, 'name')
                        ->input('text', ['class' => 'input_base'])->label(false) ?>
                </div>

                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Тема сообщения:</div>
                        </div>
                    </div>
                    <?= $form->field($model, 'subject')
                        ->input('text', ['class' => 'input_base'])->label(false) ?>
                </div>

                <div class="inputbox">
                    <div class="inputbox_label">
                        <div class="inputbox_label_2col">
                            <div class="inputbox_label_left">Текст сообщения:</div>
                        </div>
                    </div>

                    <?= $form->field($model, 'text', ['options' => ['class' => 'inputbox_input']])
                        ->textarea([
                            'cols' => 2,
                            'rows' => 2,
                            'class' => 'textarea_base',
                            'placeholder' => ''
                        ])
                        ->label(false) ?>
                </div>

                <div class="add_recipe_bottom">
                    <a href="javascript:$('#contact-form').submit();" class="b_red"><i class="fa fa-envelope"></i>Отправить</a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= RecipeThemesWidget::widget() ?>
</div>
