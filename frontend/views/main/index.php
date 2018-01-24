<?php

/* @var $this yii\web\View */

use core\helpers\RecipeHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\ForumBlockWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use widgets\TopArticlesSliderWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $recipes \core\entities\Recipe[]|array */

$this->title = 'На плите! Кулинарные рецепты на любой вкус';
?>
<div class="content_left">
    <ul class="adaptive_categories">
        <li><a href="#"><span><b>Новогодние блюда</b></span><img src="/img/banner-ny.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Закуски</b></span><img src="/img/banner_snacks.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Мясные блюда</b></span><img src="/img/banner-meat.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Рыба и морепродукты</b></span><img src="/img/banner-fish.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Салаты</b></span><img src="/img/banner_salads.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Супы</b></span><img src="/img/banner_soups.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Вторые блюда</b></span><img src="/img/banner_seconds.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Выпечка</b></span><img src="/img/banner-cakes.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Десерты</b></span><img src="/img/banner-dessert.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Соусы</b></span><img src="/img/banner_sauces.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Напитки</b></span><img src="/img/banner-drinks.jpg" width="240" height="170" alt=""/></a></li>
        <li><a href="#"><span><b>Соления и заготовки</b></span><img src="/img/banner-pickles.jpg" width="240" height="170" alt=""/></a></li>
    </ul>
    <div class="cb"></div>
    <ul class="catalogue_ul">
        <?= TopArticlesSliderWidget::widget() ?>
    </ul>
    <div class="cb"></div>
    <div class="th_2col">
        <div class="th_2col_left"><h2>Новые рецепты</h2></div>
        <div class="th_2col_right th_2col_links">
            <a href="#" class="icobox">
                <span class="icobox_left"><i class="fa fa-folder-open"></i></span>
                <span class="icobox_right">Рубрикатор рецептов</span>
            </a>
            <a href="#" class="icobox">
                <span class="icobox_left"><i class="fa fa-cubes"></i></span>
                <span class="icobox_right">Подобрать рецепт</span>
            </a>
            <a href="#" class="icobox">
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
        <a href="javascript:void(0)" class="b_brown b_shadow"><i class="fa fa-refresh"></i>Показать больше рецептов</a>
    </div>
    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

    <?= ForumBlockWidget::widget() ?>

    <div class="textbox">
        <h2>Кулинарные ингредиенты</h2>
        <ul class="ingredients">
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
            <li>
                <a href="#" class="ingredients_photo"><img src="img/article_prev.jpg" width="231" height="148" alt=""/></a>
                <a href="#">Турнепс</a>
                тали появляться круглые чуть сплюснутые корнеплоды фиолетово-белого цвета. На ценнике почему-то написано «репа», хотя это самый натуральный турнепс.
            </li>
        </ul>
        <div class="tac"><a href="#" class="b_white"><i class="fa fa-refresh"></i>Узнать больше о рецептах</a></div>
    </div>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40 hidden740"></div>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

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
