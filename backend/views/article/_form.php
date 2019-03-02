<?php

use core\forms\manage\ArticleCategoryForm;
use core\helpers\CommonVars;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\ArticleManageForm */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJsFile('https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js');
$this->registerJsFile('/js/ckeditor/ckeditor.js');
?>

<div class="article-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?php //= $form->field($model, 'author_id')->textInput() ?>

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'categoryId')->dropDownList(ArticleCategoryForm::parentCategoriesList()) ?>

        <?= $form->field($model, 'prevText')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]); ?>

        <?php /* $form->field($model, 'content')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => CommonVars::IMPERAVI_SETTINGS,
        ]);*/ ?>
        <?php /*= $form->field($model, 'content')->widget(CKEditor::class/*Yii::$app->params['CKEditorPreset']);*/ ?>
        <?= $form->field($model, 'content')->textarea(['id' => 'content-field']) ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
    window.addEventListener('load', function (e) {
        CKEDITOR.replace( 'content-field', {
            height: 700,
            contentsCss: [
                '/css/main.css',
                '/font-awesome-4.7.0/css/font-awesome.min.css',
                '/css/fixes.css'
            ],
            startupOutlineBlocks: true,
            extraPlugins: ['image', 'uploadimage', 'dialog', 'filebrowser', 'popup', 'link']
        });
    });

</script>
