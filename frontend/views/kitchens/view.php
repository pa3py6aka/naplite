<?php

use core\helpers\ContentHelper;
use core\helpers\Pluralize;
use core\helpers\SortHelper;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $kitchen \core\entities\Kitchen */
/* @var $recipesProvider \yii\data\ActiveDataProvider */

$this->title = $kitchen->name . ' | Кухни мира';

?>
<div class="content_left">
    <div class="textbox">
        <div class="tac">
            <div class="breadcump">
                <a href="/">Главная</a>
                <span><i class="fa fa-circle"></i></span>
                <a href="<?= Url::to(['/kitchens/index']) ?>">Кухни мира</a>
            </div>
        </div>
        <div class="hrecipe">
            <h1 class="fn"><?= $kitchen->name ?></h1>
            <?php if ($kitchen->image): ?>
            <div class="recipe_photo">
                <div class="recipe_photo"><img src="<?= $kitchen->getPhotoUrl() ?>" width="860" height="560" alt=""/></div>
            </div>
            <?php endif; ?>
            <?php if ($kitchen->description): ?>
            <div class="recipe_content">
                <div class="th_parent_bottom_text">
                    <span class="th_parent_seo mini" id="categorySeoText">
                        <?= ContentHelper::output($kitchen->description) ?>
                    </span>
                    <a href="javascript:void(0)" class="b_white" data-link="readSeoText"><i class="fa fa-refresh"></i>Читать далее</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="cb"></div>

    <?php if (Yii::$app->settings->get('bannerDirectAfterCategories_show')): ?>
        <div class="direct">
            <?= Yii::$app->settings->get('bannerDirectAfterCategories') ?>
        </div>
    <?php endif; ?>

    <?php Pjax::begin(['linkSelector' => '.pjax']) ?>
    <div class="sort_panel_th">
        <span class="sort_panel_th_top">
            <?= Pluralize::get($recipesProvider->totalCount, 'Найден', 'Найдено', 'Найдено', true) ?> <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?>
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
    <?php Pjax::end() ?>

</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
</div>