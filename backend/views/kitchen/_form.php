<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Kitchen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kitchen-form box box-primary">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 400,
                'buttons' => ['html','formatting','bold','italic','deleted',
                    'unorderedlist','orderedlist','outdent','indent',
                    'image','file','link','alignment','horizontalrule'],
                'plugins' => [
                    'fontsize',
                    'fontcolor',
                    'clips',
                    'fullscreen',
                ],
            ],
        ]) ?>

        <?= $form->field($model, 'imageUpload')->fileInput(['accept' => 'image/*']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
