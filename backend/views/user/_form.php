<?php

use core\entities\User\Country;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\User\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form box box-primary">
    <div class="box-header">
        <?= Html::a('Сменить пароль', ['change-password', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name')) ?>

        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'about')->textarea(['rows' => 6]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
