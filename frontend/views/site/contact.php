<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\ContactForm */

$this->title = 'Связь с администрацией сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-block">
    <br>
    <h1><?= $this->title ?></h1>

    <p>Для связи с нами используйте контактную форму ниже:</p>

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

        <div class="radio_and_but">
            <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Отправить</a></button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
