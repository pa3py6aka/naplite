<?php
/* @var $articlesProvider \yii\data\ActiveDataProvider */
/* @var $category \core\entities\Article\ArticleCategory */
/* @var $this \yii\web\View */
/* @var $search string */

use core\helpers\CategoryHelper;
use widgets\BannerWidget;
use widgets\IngredientsBlockWidget;
use widgets\Pager;
use widgets\RecipesCollectionWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use widgets\TopArticlesSliderWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Статьи по кулинарным темам";

?>
<div class="content_left" id="articlesCategory">
    <div class="th_parent">
        <div class="breadcump sub-cat"><?= CategoryHelper::getBreadCrumbs($category) ?></div>
        <div class="th_parent_top">
            <?php if (!$category->isRoot()): ?>
                <div class="th_parent_top_ico"><img src="<?= $category->getIcon() ?>"></div>
                <div class="th_parent_top_text"><h1><?= $category->name ?></h1></div>
            <?php else: ?>
                <div class="th_parent_top_ico"><i class="fa fa-book"></i></div>
                <div class="th_parent_top_text"><h1>Интересное о еде</h1></div>
            <?php endif; ?>
        </div>
        <div class="th_parent_links">
            <?php foreach ($category->children as $child): ?>
                <a href="<?= $child->getUrl() ?>"><?= $child->name ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <ul class="catalogue_ul">

        <?= TopArticlesSliderWidget::widget() ?>

        <li class="recipe_prev fix_top_articles">
            <div class="direct">
                <a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
                <div class="direct_rasp"></div>
                <a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
                <div class="direct_rasp"></div>
                <a href="#">
                    <div class="direct_th">Яндекс.Браузер</div>
                    <div class="direct_link">getyabrowser.com</div>
                    <div class="direct_descr">Без проблем откроет сервисы Яндекса</div>
                </a>
            </div>
        </li>
    </ul>
    <div class="cb"></div>

    <?php Pjax::begin(['linkSelector' => '.pjax', 'formSelector' => '.pjax']) ?>
    <div class="textbox">
        <div class="th_2col">
            <div class="th_2col_left"><h2>Новые статьи</h2></div>
            <div class="th_2col_right">
                <?= Html::beginForm(['/articles/index'], 'post', ['id' => 'search-articles-form', 'class' => 'pjax']) ?>
                    <div class="content_search">
                        <div class="content_search_left">
                            <input name="search" type="text" class="input_base" placeholder="Поиск статьи" value="<?= $search ?>"/>
                        </div>
                        <div class="content_search_right">
                            <a href="javascript:void(0)" data-link="search-articles"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <ul class="article_prev">
            <?php foreach ($articlesProvider->models as $article) {
                echo $this->render('article-item', ['article' => $article]);
            } ?>
        </ul>
    </div>

    <?= Pager::widget(['pagination' => $articlesProvider->pagination]) ?>
    <div class="p40"></div>
    <?php Pjax::end() ?>

    <?= IngredientsBlockWidget::widget() ?>
</div>
<div class="content_right">
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT]) ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>
    <div class="p40"></div>

    <?= RecipesCollectionWidget::widget() ?>
    <div class="p40"></div>

    <?= RecipeThemesWidget::widget() ?>
</div>
