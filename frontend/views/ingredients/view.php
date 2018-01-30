<?php

use core\entities\Ingredient\Ingredient;
use core\helpers\BlogHelper;
use core\helpers\ContentHelper;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\IngredientsBlockWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $ingredient Ingredient */
/* @var $commentModel \core\forms\CommentForm */

$this->title = Html::encode($ingredient->title);

?>
<div class="content_left">
    <div class="blog_adaptive_menu">
        <div class="blog_adaptive_menu_left">
            <select class="select_base" name="blog-category-selector">
                <option value="<?= Url::to(['/blog/index']) ?>">Все ингредиенты</option>
                <?= BlogHelper::getOptionsWithLinks(Ingredient::class) ?>
            </select>
        </div>
    </div>
    <div class="textbox">
        <div class="breadcump">
            <a href="/">Главная</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/ingredients/index']) ?>">Ингредиенты</a>
            <span><i class="fa fa-circle"></i></span>
            <a href="<?= Url::to(['/ingredients/index', 'category' => $ingredient->category->slug]) ?>"><?= $ingredient->category->name ?></a>
        </div>
        <div class="post_page_content">
            <div class="post_page_top">
                <h1><?= Html::encode($ingredient->title) ?></h1>
                <?= ContentHelper::output($ingredient->content) ?>
            </div>
        </div>
    </div>

    <?= IngredientsBlockWidget::widget(['currentIngredientId' => $ingredient->id]) ?>

</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
</div>


