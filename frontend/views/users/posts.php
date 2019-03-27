<?php

use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\Pager;
use widgets\SidebarCollectionsWidget;
use widgets\SocialBlockWidget;

/* @var $this \yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $provider \yii\data\ActiveDataProvider */

/* @var $blog \core\entities\Blog\Blog */

$this->title = $user->fullName . ' | Посты';

?>
<div class="content_left" id="blogsListPage">
    <?= $this->render('user-top-block', ['action' => 'posts', 'user' => $user]) ?>
    <div class="textbox">
        <div class="th_2col">
            <h2>Посты пользователя</h2>
        </div>
        <div class="blog_main">
            <?php if (!count($provider->models)): ?>
                <br />
                <div class="no-counts">
                    <?php if (Yii::$app->user->id === $user->id): ?>
                        <?= Yii::$app->settings->get('emptyBlockForPosts') ?>
                    <?php else: ?>
                        Пользователь не создал ещё ни одного поста на форуме
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($provider->models as $blog): ?>
                    <?= $this->render('@frontend/views/blog/blog-item', ['blog' => $blog]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if (Yii::$app->settings->get('bannerPagenator_show')) {
        echo Yii::$app->settings->get('bannerPagenator');
    } ?>

    <?= Pager::widget(['pagination' => $provider->pagination]) ?>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>

    <?= SidebarCollectionsWidget::widget() ?>
</div>
