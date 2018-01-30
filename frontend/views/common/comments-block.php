<?php

/* @var $this \yii\web\View */
/* @var $commentModel \core\forms\CommentForm */
/* @var $comments \core\entities\Recipe\RecipeComment[]|\core\entities\Blog\BlogComment[] */


use core\access\Rbac;
use core\helpers\ContentHelper;
use frontend\assets\CKEditorAsset;

$this->registerJsFile('/js/comments.js?v=' . filemtime(Yii::getAlias('@webroot/js/comments.js')), ['depends' => CKEditorAsset::class]);

?>
<?= $this->render('comment-form', ['commentModel' => $commentModel, 'n' => 1]) ?>

<?php if (count($comments)): ?>
    <ul class="comments">
        <?php foreach ($comments as $comment): ?>
            <li class="comment">
                <div class="comment_left">
                    <a href="<?= $comment->author->pageUrl ?>">
                        <img src="<?= $comment->author->avatarUrl ?>" alt=""/>
                    </a>
                </div>
                <div class="comment_right">
                    <div class="comment_name"><a href="javascript:void(0)"><b data-username="here"><?= $comment->author->fullName ?></b></a><span class="date">, <?= Yii::$app->formatter->asRelativeTime($comment->created_at) ?></span></div>
                    <div class="comment_text">
                        <?= ContentHelper::output($comment->content) ?>
                    </div>
                </div>
                <div class="comment_reply">
                    <a href="javascript:void(0)" class="<?= Yii::$app->user->can(Rbac::ROLE_USER) ? 'replyToComment' : 'loginButton' ?>">
                        <i class="fa fa-comment-o"></i>Ответить
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="p40"></div>

    <?= $this->render('comment-form', ['commentModel' => $commentModel, 'n' => 2]) ?>

<?php endif;
