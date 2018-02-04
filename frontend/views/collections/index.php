<?php

use core\helpers\ContentHelper;
use core\helpers\Pluralize;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $collection \core\entities\Recipe\Collection\Collection */
/* @var $this \yii\web\View */
/* @var $recipesProvider \yii\data\ActiveDataProvider */


$this->title = 'Подборка рецептов по теме ' . $collection->title;

?>
<div class="content_left">
    <div class="th_parent">
        <div class="breadcump sub-cat">
            <a href="/">Главная</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/recipes/index']) ?>">Подборки</a>
        </div>
        <div class="th_parent_top">
            <div class="th_parent_top_text"><h1><?= $collection->title ?></h1></div>
        </div>
        <?php if ($collection->description): ?>
        <div class="th_parent_bottom_text">
            <span class="th_parent_seo mini" id="categorySeoText">
                <?= ContentHelper::output($collection->description) ?>
            </span>
            <a href="javascript:void(0)" class="b_white" data-link="readSeoText"><i class="fa fa-refresh"></i>Читать далее</a>
        </div>
        <?php endif; ?>
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
        <span class="sort_panel_th_top">В подборке «<?= $collection->title ?>» <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?></span>
        <ul class="sort_panel_th_bottom">
            <li><b>Сортировать:</b></li>
            <li class="<?= $recipesProvider->sort->getAttributeOrder('id') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= $recipesProvider->sort->createUrl('id') ?>" class="pjax"><i class="fa fa-clock-o"></i>По дате</a>
            </li>
            <li class="<?= $recipesProvider->sort->getAttributeOrder('rate') !== null ? 'sort_panel_th_bottom_active' : '' ?>">
                <a href="<?= $recipesProvider->sort->createUrl('rate') ?>" class="pjax"><i class="fa fa-star-o"></i>По популярности</a>
            </li>
        </ul>
    </div>

    <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $recipesProvider]) ?>

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
