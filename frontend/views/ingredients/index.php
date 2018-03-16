<?php

use core\helpers\CategoryHelper;
use core\helpers\ContentHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\Pager;
use widgets\SidebarCollectionsWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $ingredientsProvider \yii\data\ActiveDataProvider */
/* @var $category \core\entities\Ingredient\IngredientCategory */
/* @var $this \yii\web\View */
/* @var $search string */

/* @var $ingredient \core\entities\Ingredient\Ingredient */

$this->title = "Кулинарные ингридиенты";

?>
<div class="content_left" id="ingredientsCategory">
    <div class="th_parent">
        <div class="breadcump sub-cat"><?= CategoryHelper::getBreadCrumbs($category) ?></div>
        <div class="th_parent_top">
            <?php if (!$category->isRoot()): ?>
                <div class="th_parent_top_ico"><img src="<?= $category->getIcon() ?>"></div>
                <div class="th_parent_top_text"><h1><?= $category->name ?></h1></div>
            <?php else: ?>
                <div class="th_parent_top_ico"><i class="fa fa-shopping-bag"></i></div>
                <div class="th_parent_top_text"><h1>Ингредиенты</h1></div>
            <?php endif; ?>
        </div>
        <div class="th_parent_links">
            <?php foreach ($category->children as $child): ?>
                <a href="<?= $child->getUrl() ?>"><?= $child->name ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="cb"></div>

    <?php Pjax::begin(['linkSelector' => '.pjax', 'formSelector' => '.pjax']) ?>
    <div class="textbox">
        <div class="th_2col">
            <div class="th_2col_left"><h2>Новые ингредиенты</h2></div>
            <div class="th_2col_right">
                <?= Html::beginForm(['/ingredients/index'], 'get', ['id' => 'search-ingredients-form', 'class' => 'pjax']) ?>
                    <div class="content_search">
                        <div class="content_search_left">
                            <input name="search" type="text" class="input_base" placeholder="Поиск ингредиентов" value="<?= $search ?>"/>
                        </div>
                        <div class="content_search_right">
                            <a href="javascript:void(0)" data-link="search-ingredients"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <ul class="article_prev li-last-no-border">
            <?php if ($ingredientsProvider->count): ?>
                <?php foreach ($ingredientsProvider->models as $ingredient): ?>
                    <li>
                        <div class="article_prev_photo">
                            <span><img src="<?= $ingredient->getImageUrl() ?>" width="231" height="148" alt=""/></span>
                        </div>
                        <div class="article_prev_text">
                            <a href="<?= $ingredient->getUrl() ?>"><?= Html::encode($ingredient->title) ?></a>
                            <?= ContentHelper::output($ingredient->prev_text) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="not-found">Ничего не найдено</div>
            <?php endif; ?>
        </ul>
    </div>

    <?php if (Yii::$app->settings->get('bannerPagenator_show')) {
        echo Yii::$app->settings->get('bannerPagenator');
    } ?>

    <?= Pager::widget(['pagination' => $ingredientsProvider->pagination]) ?>
    <div class="p40"></div>
    <?php Pjax::end() ?>

    <?= ArticlesWidget::widget() ?>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= SidebarCollectionsWidget::widget() ?>
    <div class="p40"></div>

    <?= RecipeThemesWidget::widget() ?>
</div>
