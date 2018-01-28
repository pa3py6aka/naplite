<?php

/* @var $this \yii\web\View */
/* @var $model \core\forms\BlogForm */
/* @var $blog \core\entities\Blog\Blog|null */

use core\entities\Blog\BlogCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="/">Главная</a>
                <span><i class="fa fa-circle"></i></span>
                <a href="#">Личный кабинет</a>
            </div>
            <h1><?= $blog ? Html::encode($blog->title) : "Ваш новый пост" ?></h1>
        </div>
        <div class="form_center" id="recipe-form">
            <?php $form = ActiveForm::begin(['id' => 'blogForm']) ?>
            <div class="inputbox">
                <div class="inputbox_label">Заголовок:</div>

                <?= $form->field($model, 'title', ['options' => ['class' => 'inputbox_input']])
                    ->textInput(['class' => 'input_base', 'placeholder' => 'Введите заголовок'])
                    ->label(false) ?>

            </div>
            <div class="inputbox">
                <div class="inputbox_label">Раздел:</div>

                <?= $form->field($model, 'categoryId', ['options' => ['class' => 'inputbox_input']])
                    ->dropDownList(ArrayHelper::map(BlogCategory::find()->asArray()->all(), 'id', 'name'), ['class' => 'select_base', 'prompt' => 'Выберите раздел'])
                    ->label(false) ?>

            </div>
            <div class="inputbox">
                <div class="inputbox_label">
                    <div class="inputbox_label_2col">
                        <div class="inputbox_label_left">Текст поста:</div>
                        <div class="inputbox_label_right"><img src="/img/wsw.jpg" width="155" height="19" alt=""/></div>
                    </div>
                </div>

                <?= $form->field($model, 'content', ['options' => ['class' => 'inputbox_input']])
                    ->textarea(['cols' => 2, 'rows' => 2, 'class' => 'textarea_base', 'placeholder' => 'Напишите текст Вашего поста'])
                    ->label(false) ?>

            </div>

            <div class="add_recipe_bottom">
                <a href="javascript:void(0)" class="b_red" data-button="submitForm"><i class="fa fa-plus"></i><?= $blog ? "Сохранить" : "Опубликовать" ?></a>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<div class="content_right">
    <div class="rightbox_nop">
        <?php /*
        <!--
        <div class="swith_bottom">
            <div class="radiobox_input">
                <div class="checkbox_outer">
                    <input type="checkbox" id="filter_product_country8" name="filter_product_country8" value="8" class="checkbox"<?= $model->commentsNotify ? ' checked' : '' ?>>
                    <label id="filter_product_country_label8" for="filter_product_country8">
                        Получать комментарии к рецепту на почту
                    </label>
                </div>
            </div>
        </div>
        -->
        */ ?>
    </div>
</div>
