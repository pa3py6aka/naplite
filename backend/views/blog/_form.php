<?php

use core\entities\Blog\BlogCategory;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Blog\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(BlogCategory::find()->asArray()->all(), 'id', 'name')) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
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

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
