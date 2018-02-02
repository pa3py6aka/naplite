<?php
/* @var $this \yii\web\View */
/* @var $blog \core\entities\Blog\Blog */
/* @var $commentModel \core\forms\CommentForm */

use core\helpers\BlogHelper;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\BlogCategoriesWidget;
use widgets\ForumBlockWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$this->title = Html::encode($blog->title);

?>
<div class="content_left">
    <div class="blog_adaptive_menu">
        <div class="blog_adaptive_menu_left">
            <select class="select_base" name="blog-category-selector">
                <option value="<?= Url::to(['/blog/index']) ?>">Все публикации</option>
                <?= BlogHelper::getOptionsWithLinks() ?>
            </select>
        </div>
        <div class="blog_adaptive_menu_right">
            <a href="javascript:void(0)" class="b_red"><i class="fa fa-pencil"></i>Написать в блог</a>
        </div>
    </div>
    <div class="textbox">
        <div class="breadcump">
            <a href="/">Главная</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/blog/index']) ?>">Кулинарный форум</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/blog/index', 'category' => $blog->category->slug]) ?>"><?= $blog->category->name ?></a>
        </div>
        <div class="post_page_content">
            <div class="post_page_top">
                <h1><?= Html::encode($blog->title) ?></h1>
                <?= HtmlPurifier::process($blog->content) ?>
            </div>
            <div class="post_page_stat">
                <a href="<?= $blog->author->pageUrl ?>" class="userpick">
                    <span class="userpick_photo"><img src="<?= $blog->author->avatarUrl ?>" alt=""/></span>
                    <span class="userpick_name"><?= $blog->author->fullName ?></span>
                    <span class="userpick_date"><?= Yii::$app->formatter->asRelativeTime($blog->created_at) ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="textbox" id="comments">
        <div class="comment_th">
            <h3>Комментарии пользователей</h3>
        </div>
        <?= $this->render('@frontend/views/common/comments-block', [
            'commentModel' => $commentModel,
            'comments' => $blog->blogComments,
        ]) ?>
    </div>

    <?= ForumBlockWidget::widget() ?>
</div>
<div class="content_right">
    <div class="cb tac">
        <a href="<?= Yii::$app->user->isGuest ? 'javascript:void(0)' : Url::to(['/blog/create']) ?>" class="b_red<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>">
            <i class="fa fa-comment"></i>Написать в блог
        </a>
    </div>
    <div class="p40"></div>

    <?= BlogCategoriesWidget::widget(['activeCategory' => $blog->category]) ?>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
</div>
