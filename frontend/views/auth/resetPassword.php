<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \core\forms\auth\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <br>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Придумайте новый пароль:</p>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <?= $form->field($model, 'password')
            ->passwordInput(['autofocus' => true, 'class' => 'input_base'])->label(false) ?>

        <div class="radio_and_but">
            <button type="submit" class="radio_and_but_right blind-button"><a type="submit" class="b_red">Сбросить</a></button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
