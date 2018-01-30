<?php

use core\entities\Article\Article;
use core\helpers\BlogHelper;
use core\helpers\ContentHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $article Article */
/* @var $commentModel \core\forms\CommentForm */

$this->title = Html::encode($article->title);

?>
<div class="content_left">
    <div class="blog_adaptive_menu">
        <div class="blog_adaptive_menu_left">
            <select class="select_base" name="blog-category-selector">
                <option value="<?= Url::to(['/blog/index']) ?>">Все публикации</option>
                <?= BlogHelper::getOptionsWithLinks(Article::class) ?>
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
            <a href="<?= Url::to(['/articles/index']) ?>">Статьи по кулинарии</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/articles/index', 'category' => $article->category->slug]) ?>"><?= $article->category->name ?></a>
        </div>
        <div class="post_page_content">
            <div class="post_page_top">
                <h1><?= Html::encode($article->title) ?></h1>
                <?= ContentHelper::output($article->content) ?>
            </div>
            <div class="post_page_stat">
                <a href="<?= $article->author->pageUrl ?>" class="userpick">
                    <span class="userpick_photo"><img src="<?= $article->author->avatarUrl ?>" alt=""/></span>
                    <span class="userpick_name"><?= $article->author->fullName ?></span>
                    <span class="userpick_date"><?= Yii::$app->formatter->asRelativeTime($article->created_at) ?></span>
                </a>
            </div>
        </div>
    </div>

    <?= ArticlesWidget::widget(['currentArticleId' => $article->id]) ?>

    <div class="textbox" id="comments">
        <div class="comment_th">
            <h3>Комментарии пользователей</h3>
        </div>
        <?= $this->render('@frontend/views/common/comments-block', [
            'commentModel' => $commentModel,
            'comments' => $article->comments,
        ]) ?>
    </div>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
</div>


