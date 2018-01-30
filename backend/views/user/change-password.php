<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\User\ChangePasswordForm */
/* @var $user \core\entities\User\User */

$this->title = 'Установка пароля';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->fullName, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="user-update">

    <div class="user-form box box-primary">
        <?php $form = ActiveForm::begin(); ?>
        <div class="box-body table-responsive">

            <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'confirmPassword')->passwordInput(['maxlength' => true]) ?>

        </div>
        <div class="box-footer">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>

