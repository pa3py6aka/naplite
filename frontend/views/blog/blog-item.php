<?php
/* @var $blog \core\entities\Blog\Blog */

use yii\helpers\Html;

?>
<div class="blog_prev">
    <a href="<?= $blog->getUrl() ?>" class="blog_prev_th"><?= Html::encode($blog->title) ?></a>
    <div class="blog_prev_stat">
        <div class="blog_prev_stat_left">
            <a href="<?= $blog->author->pageUrl ?>" class="userpick">
                <span class="userpick_photo"><img src="<?= $blog->author->avatarUrl ?>" alt="<?= $blog->author->fullName ?>"/></span>
                <span class="userpick_name"><?= $blog->author->fullName ?></span>
                <span class="userpick_date"><?= Yii::$app->formatter->asRelativeTime($blog->created_at) ?></span>
            </a>
        </div>
        <div class="blog_prev_stat_right">
            <span class="recipe_prev_stat_left">
                <a href="<?= $blog->getUrl(false, 'comments') ?>" class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-comment-o"></i></span>
                    <span class="stat_ico_right"><?= $blog->comments_count ?></span>
                </a>
                <a href="javascript:void(0)" class="stat_ico">
                    <span class="stat_ico_left"><i class="fa fa-eye"></i></span>
                    <span class="stat_ico_right"><?= $blog->views ?></span>
                </a>
            </span>
        </div>
    </div>
</div>
