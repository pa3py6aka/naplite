<?php

/* @var $this \yii\web\View */
/* @var $kitchens \core\entities\Kitchen[] */

use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\RecipeThemesWidget;
use widgets\TopArticlesSliderWidget;
use yii\helpers\Url;

$this->title = "Кухни мира";

?>
<div class="content_left" id="articlesCategory">
    <div class="th_parent">
        <div class="breadcump sub-cat">
            <a href="/">Главная</a>
        </div>
        <div class="th_parent_top">
            <div class="th_parent_top_text"><h1>Кухни мира</h1></div>
        </div>
    </div>

    <div class="cb"></div>
    <ul class="adaptive_categories min-height-100">
        <?php foreach ($kitchens as $kitchen): ?>
            <li>
                <a href="<?= $kitchen->getUrl() ?>">
                    <span><b><?= $kitchen->name ?></b></span>
                    <span class="grad"></span>
                    <?php if ($kitchen->image): ?>
                        <img src="<?= $kitchen->getPhotoUrl(false, true) ?>" width="240" height="170" alt="<?= $kitchen->name ?>"/>
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="cb"></div>

    <ul class="catalogue_ul">

        <?= TopArticlesSliderWidget::widget() ?>

        <?php if (Yii::$app->settings->get('bannerDirectAfterCategories_show')): ?>
            <li class="recipe_prev fix_top_articles">
                <div class="direct">
                    <?= Yii::$app->settings->get('bannerDirectAfterCategories') ?>
                </div>
            </li>
        <?php endif; ?>
    </ul>
    <div class="cb"></div>

</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= RecipeThemesWidget::widget() ?>

    <?= BestChefsWidget::widget() ?>
</div>
