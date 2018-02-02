<?php

use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\ForumBlockWidget;
use widgets\IngredientsBlockWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use widgets\TopArticlesSliderWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $recipes \core\entities\Recipe\Recipe[]|array */
/* @var $collections \core\entities\Recipe\Collection\Collection[] */

$this->title = 'На плите! Кулинарные рецепты на любой вкус';
?>
<div class="content_left">
    <?php if (count($collections)): ?>
        <ul class="adaptive_categories">
            <?php foreach ($collections as $collection): ?>
                <li>
                    <a href="<?= $collection->getUrl() ?>">
                        <span><b><?= $collection->title ?></b></span>
                        <img src="<?= $collection->getImageUrl() ?>" width="240" height="170" alt="<?= $collection->title ?>"/>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="cb"></div>

    <ul class="catalogue_ul">
        <?= TopArticlesSliderWidget::widget() ?>
    </ul>

    <div class="cb"></div>
    <div class="th_2col">
        <div class="th_2col_left"><h2>Новые рецепты</h2></div>
        <div class="th_2col_right th_2col_links">
            <a href="<?= Url::to(['/category/view']) ?>" class="icobox">
                <span class="icobox_left"><i class="fa fa-folder-open"></i></span>
                <span class="icobox_right">Рубрикатор рецептов</span>
            </a>
            <a href="javascript:void(0)" class="icobox">
                <span class="icobox_left"><i class="fa fa-cubes"></i></span>
                <span class="icobox_right">Подобрать рецепт</span>
            </a>
            <a href="javascript:void(0)" class="icobox" data-link="goToSearch">
                <span class="icobox_left"><i class="fa fa-search"></i></span>
                <span class="icobox_right">Поиск<span class="hidden1260"> рецептов</span></span>
            </a>
        </div>
    </div>
    <ul class="catalogue_ul">
        <?php foreach ($recipes as $recipe): ?>
            <?= $this->render('@frontend/views/recipes/recipe-item', ['recipe' => $recipe]) ?>
        <?php endforeach; ?>
    </ul>
    <div class="cb tac">
        <a href="<?= Url::to(['/category/view']) ?>" class="b_brown b_shadow"><i class="fa fa-refresh"></i>Показать больше рецептов</a>
    </div>
    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

    <?= ForumBlockWidget::widget() ?>

    <?= IngredientsBlockWidget::widget() ?>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple2']) ?>

    <?= RecipeThemesWidget::widget() ?>
</div>

<?php if (Yii::$app->request->get('signup') == 'ok') {
    echo $this->render('@frontend/views/auth/signup-ok-modal');
    $this->registerJs('$("#signupOkModal").show();');
} else if (Yii::$app->session->hasFlash("confirm-success")) {
    Yii::$app->session->removeFlash("confirm-success");
    echo $this->render('@frontend/views/auth/confirm-ok-modal');
    $this->registerJs('$("#confirmOkModal").show();');
} ?>
