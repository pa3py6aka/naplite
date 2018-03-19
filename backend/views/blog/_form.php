<?php

use core\entities\Blog\BlogCategory;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\Blog\Blog */
/* @var $form yii\widgets\ActiveForm */
/* @var $blogForm \core\forms\BlogForm */

?>

<div class="blog-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($blogForm, 'categoryId')->dropDownList(ArrayHelper::map(BlogCategory::find()->asArray()->all(), 'id', 'name')) ?>

        <?= $form->field($blogForm, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($blogForm, 'content')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'imageUpload' => Url::to(['/blog/image-upload']),
                'buttons' => ['html','formatting','bold','italic','deleted',
                    'unorderedlist','orderedlist','outdent','indent',
                    'image','file','link','alignment','horizontalrule'],
                'plugins' => [
                    'fontsize',
                    'fontcolor',
                    'clips',
                    'fullscreen',
                    'imagemanager',
                ],
            ],
        ]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
