<?php
use core\access\Rbac;
use mihaildev\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/* @var $commentModel \core\forms\CommentForm */
/* @var $n int */

?>
<?php if (Yii::$app->user->can(Rbac::ROLE_USER)): ?>
    <div class="comment_form">
        <div class="comment_form_top">
            <?php $form = ActiveForm::begin(['id' => 'commentForm_' . $n]) ?>
            <?= $form->field($commentModel, 'content')
                ->textarea([
                    'id' => 'commentform-content-' . $n,
                    'cols' => 10,
                    'rows' => 10,
                    'class' => 'textarea_base textarea_comment',
                    'placeholder' => 'Оставьте свой комментарий'
                ])->label(false) ?>
            <?php /*= $form->field($commentModel, 'content')->widget(CKEditor::className(),[
                'editorOptions' => [
                    'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ],
            ])->label(false); */ ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="comment_form_bottom">
            <div class="comment_form_bottom_right"><span><a href="javascript:void(0)" class="b_red" data-link="addComment" data-n="<?= $n ?>">Оставить комментарий</a></span></div>
        </div>
    </div>
<?php elseif (Yii::$app->user->isGuest && $n < 2): ?>
    <div class="comment_form" style="text-align:center;">
        <strong>Для того чтобы оставлять комментарии, Вам необходимо <a href="javascript:void" class="loginButton text-link">войти</a> на сайт</strong>
    </div>
<?php endif; ?>
