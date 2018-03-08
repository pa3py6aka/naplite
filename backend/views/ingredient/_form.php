<?php

use core\forms\manage\IngredientCategoryForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\IngredientManageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ingredient-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput() ?>

        <?= $form->field($model, 'categoryId')->dropDownList(IngredientCategoryForm::parentCategoriesList()) ?>

        <?= $form->field($model, 'show')->dropDownList([0 => 'Нет', 1 => 'Да'])
            ->hint('Если не отображать, то ингредиент будет использоваться только для автокомплита в форме добавления рецепта') ?>

        <?= $form->field($model, 'prevText')->widget(Widget::className(), [
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
        ]); ?>

        <?= $form->field($model, 'content')->widget(Widget::className(), [
            'id' => 'redactor',
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 300,
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
        ]); ?>

        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
