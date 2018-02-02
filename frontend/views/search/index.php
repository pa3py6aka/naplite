<?php

/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider|null */
/* @var $search string|null */

use core\helpers\Pluralize;
use core\helpers\SortHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\widgets\Pjax;

$this->title = $search ? $search . ' | ' : '';
$this->title .= Yii::$app->name . '| Поиск рецепта';

?>
<div class="content_left">
    <div class="th_parent">
        <div class="breadcump"><a href="/">Главная</a></div>
        <div class="th_parent_top">
            <div class="th_parent_top_ico"><i class="fa fa-search"></i></div>
            <div class="th_parent_top_text"><h1>Поиск рецепта</h1></div>
        </div>
        <div class="th_parent_bottom_text">
            <span class="th_parent_seo">
                <?php if (!$search): ?>
                    Для поиска рецепта, пожалуйста, введите Ваш запрос в поисковую форму вверху сайта
                <?php elseif (!$provider->totalCount): ?>
                    По данному запросу не найдено ни одного рецепта
                <?php else: ?>
                    По запросу <b>&laquo;<?= $search ?>&raquo;</b> <?= Pluralize::get($provider->totalCount, 'найден', 'найдено', 'найдено', true) ?> <?= Pluralize::get($provider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <div class="cb"></div>

    <?php if (Yii::$app->settings->get('bannerDirectAfterCategories_show')): ?>
        <div class="direct">
            <?= Yii::$app->settings->get('bannerDirectAfterCategories') ?>
        </div>
    <?php endif; ?>

    <?php Pjax::begin([
        'linkSelector' => '.pjax'
    ]) ?>


    <div class="sort_panel_th">
        <ul class="sort_panel_th_bottom">
            <?php if ($provider->totalCount > 1): ?>
            <li><b>Сортировать:</b></li>
            <li class="<?= $provider->sort->getAttributeOrder('id') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= SortHelper::getUrl($provider->sort, 'id') ?>" class="pjax"><i class="fa fa-clock-o"></i>По дате</a>
            </li>
            <li class="<?= $provider->sort->getAttributeOrder('rate') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= SortHelper::getUrl($provider->sort, 'rate') ?>" class="pjax"><i class="fa fa-star-o"></i>По популярности</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $provider]) ?>

    <?php Pjax::end() ?>

    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple2']) ?>

    <?= RecipeThemesWidget::widget() ?>
</div>
