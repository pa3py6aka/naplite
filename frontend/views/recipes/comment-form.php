<?php
use core\access\Rbac;
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
                    'cols' => 10,
                    'rows' => 10,
                    'class' => 'textarea_base textarea_comment',
                    'placeholder' => 'Оставьте свой комментарий'
                ])->label(false) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="comment_form_bottom">
            <div class="comment_form_bottom_left"><img src="/img/wsw.jpg" width="155" height="19" alt=""/></div>
            <div class="comment_form_bottom_right"><span><a href="javascript:void(0)" class="b_red" data-link="addComment" data-n="<?= $n ?>">Оставить комментарий</a></span></div>
        </div>
    </div>
<?php endif; ?>
