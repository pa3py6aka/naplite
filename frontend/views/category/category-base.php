<?php

/* @var $category \core\entities\Recipe\Category */
/* @var $this \yii\web\View */
/* @var $recipesProvider \yii\data\ActiveDataProvider */

use core\helpers\Pluralize;
use core\helpers\SortHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $category->getHeadingTile();

?>
<div class="content_left">
    <div class="th_parent">
        <div class="breadcump sub-cat">
            <a href="/">Главная</a>
            <?= $category->depth > 0 ? '<span><i class="fa fa-circle"></i></span><a href="' . Url::to(['/recipes/index']) . '">Рецепты</a>' : '' ?></div>
        <div class="th_parent_top">
            <div class="th_parent_top_ico"><img src="<?= $category->getIcon() ?>" width="50" height="40" alt=""/></div>
            <div class="th_parent_top_text"><h1><?= $category->getHeadingTile() ?></h1></div>
        </div>
        <?php if ($category->description): ?>
        <div class="th_parent_bottom_text">
            <span class="th_parent_seo mini" id="categorySeoText">
                <?= nl2br($category->description) ?>
            </span>
            <a href="javascript:void(0)" class="b_white" data-link="readSeoText"><i class="fa fa-refresh"></i>Читать далее</a>
        </div>
        <?php endif; ?>
    </div>
    <div class="cb"></div>
    <ul class="adaptive_categories min-height-100">
        <?php foreach ($category->children as $child): ?>
            <li>
                <a href="<?= Url::to(['/category/view', 'slug' => $child->slug]) ?>">
                    <span><b><?= $child->name ?></b></span>
                    <span class="grad"></span>
                    <?php if ($child->imageUrl): ?>
                        <img src="<?= $child->imageUrl ?>" width="240" height="170" alt="<?= $child->name ?>"/>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="cb"></div>

    <?php if (Yii::$app->settings->get('bannerDirectAfterCategories_show')): ?>
        <div class="direct">
            <?= Yii::$app->settings->get('bannerDirectAfterCategories') ?>
        </div>
    <?php endif; ?>

    <?php /*Pjax::begin([
        'linkSelector' => '.pjax'
    ])*/ ?>
    <div class="sort_panel_th">
        <span class="sort_panel_th_top">
            <?php if ($category->depth > 0): ?>
                В категории «<?= $category->name ?>» <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?>
            <?php else: ?>
                В нашей базе <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?>
            <?php endif; ?>
        </span>
        <ul class="sort_panel_th_bottom">
            <li><b>Сортировать:</b></li>
            <li class="<?= $recipesProvider->sort->getAttributeOrder('id') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= SortHelper::getUrl($recipesProvider->sort, 'id') ?>" class="pjax"><i class="fa fa-clock-o"></i>По дате</a>
            </li>
            <li class="<?= $recipesProvider->sort->getAttributeOrder('rate') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= SortHelper::getUrl($recipesProvider->sort, 'rate') ?>" class="pjax"><i class="fa fa-star-o"></i>По популярности</a>
            </li>
        </ul>
    </div>

    <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $recipesProvider]) ?>

    <?php // Pjax::end() ?>

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
