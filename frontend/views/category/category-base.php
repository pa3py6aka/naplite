<?php
/* @var $category \core\entities\Category */
/* @var $this \yii\web\View */
/* @var $recipesProvider \yii\data\ActiveDataProvider */

use core\entities\Recipe;
use core\helpers\Pluralize;
use core\helpers\RecipeHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->title = $category->getHeadingTile();

?>
<div class="content_left">
    <div class="th_parent">
        <div class="breadcump"><a href="/">Главная</a></div>
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
                    <?php if ($child->imageUrl): ?>
                        <img src="<?= $child->imageUrl ?>" width="240" height="170" alt="<?= $child->name ?>"/>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="cb"></div>

    <?php Pjax::begin([
        'linkSelector' => '.pjax'
    ]) ?>
    <div class="sort_panel_th">
        <span class="sort_panel_th_top">В подборке «<?= $category->name ?>» <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?></span>
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

    <?= $this->render('recipes-block', ['recipesProvider' => $recipesProvider]) ?>

    <?php Pjax::end() ?>

    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

    <?= RecipeThemesWidget::widget() ?>
</div>
