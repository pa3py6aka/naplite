<?php

use core\helpers\BlogHelper;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\BlogCategoriesWidget;
use widgets\Pager;
use widgets\SidebarCollectionsWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $category \core\entities\Blog\BlogCategory|null */
/* @var $provider \yii\data\ActiveDataProvider */
/* @var $search string */

/* @var $blog \core\entities\Blog\Blog */

$this->title = 'Кулинарный форум';
if ($category) {
    $this->title = $category->name . ' | ' . $this->title;
}

?>
<div class="content_left" id="blogsListPage">
    <div class="blog_adaptive_menu">
        <div class="blog_adaptive_menu_left">
            <select class="select_base" name="blog-category-selector">
                <option value="<?= Url::to(['/blog/index']) ?>">Все публикации</option>
                <?= BlogHelper::getOptionsWithLinks() ?>
            </select>
        </div>
        <div class="blog_adaptive_menu_right">
            <a href="<?= Yii::$app->user->isGuest ? 'javascript:void(0)' : Url::to(['/blog/create']) ?>" class="b_red<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>">
                <i class="fa fa-pencil"></i>Написать в блог
            </a>
        </div>
    </div>
    <div class="textbox">
        <div class="th_2col">
            <div class="th_2col_left"><h2>Кулинарный форум</h2></div>
            <div class="th_2col_right th_input">
                <?= Html::beginForm(['/blog/index'], 'get', ['id' => 'searchBlogsForm']) ?>
                    <div class="content_search">
                        <div class="content_search_left">
                            <input type="text" class="input_base" placeholder="Поиск по форуму" name="search" value="<?= $search ?>"/>
                        </div>
                        <div class="content_search_right">
                            <a href="javascript:void(0)"><i class="fa fa-search" data-button="submit-blog-search"></i></a>
                        </div>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <div class="blog_main">
            <?php foreach ($provider->models as $blog): ?>
                <?= $this->render('blog-item', ['blog' => $blog]) ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (Yii::$app->settings->get('bannerPagenator_show')) {
        echo Yii::$app->settings->get('bannerPagenator');
    } ?>

    <?= Pager::widget(['pagination' => $provider->pagination]) ?>
</div>
<div class="content_right">
    <div class="cb tac">
        <a href="<?= Yii::$app->user->isGuest ? 'javascript:void(0)' : Url::to(['/blog/create']) ?>" class="b_red<?= Yii::$app->user->isGuest ? ' loginButton' : '' ?>">
            <i class="fa fa-comment"></i>Написать в блог
        </a>
    </div>
    <div class="p40"></div>

    <?= BlogCategoriesWidget::widget(['activeCategory' => $category]) ?>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= SidebarCollectionsWidget::widget() ?>
</div>
