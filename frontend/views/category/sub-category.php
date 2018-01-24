<?php
/* @var $category \core\entities\Category */

use core\entities\Holiday;
use core\helpers\CategoryHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\RecipesCollectionWidget;
use widgets\RecipeThemesWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $recipesProvider \yii\data\ActiveDataProvider */

?>
<div class="content_left">
    <div class="th_parent">
        <div class="breadcump sub-cat">
            <?= CategoryHelper::getBreadCrumbs($category) ?>
        </div>
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
    <?php if (count($category->children)): ?>
    <div class="th_parent_links">
        <?php foreach ($category->children as $child): ?>
            <a href="<?= $child->url ?>"><?= $child->name ?></a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="cb"></div>

    <?php Pjax::begin([
        'linkSelector' => '.pjax'
    ]) ?>
    <div class="sort_panel">
        <div class="sort_panel_left">
            <div class="inputbox_2_col">
                <div class="inputbox_label_left">Показывать:</div>
                <div class="inputbox_label_right">
                    <select name="sort-selector" class="select_base" data-for-link="sort-selector-link">
                        <option value="<?= $recipesProvider->sort->createUrl('id') ?>"<?= $recipesProvider->sort->getAttributeOrder('id') == SORT_DESC ? ' selected' : '' ?>>Самые новые</option>
                        <option value="<?= $recipesProvider->sort->createUrl('rate') ?>"<?= $recipesProvider->sort->getAttributeOrder('rate') == SORT_DESC ? ' selected' : '' ?>>Самые популярные</option>
                        <option value="<?= $recipesProvider->sort->createUrl('comments_count') ?>"<?= $recipesProvider->sort->getAttributeOrder('comments_count') == SORT_DESC ? ' selected' : '' ?>>Самые обсуждаемые</option>
                    </select>
                    <a href="#" class="hidden pjax" data-link="sort-selector-link"></a>
                </div>
            </div>
        </div>
        <div class="sort_panel_right">
            <div class="inputbox_2_col">
                <div class="inputbox_label_left">Повод:</div>
                <div class="inputbox_label_right">
                    <select name="occasion-selector" class="select_base" data-for-link="occasion-selector-link">
                        <option value="<?= $category->url ?>">Для всех праздников</option>
                        <?php $currentOccasion = Yii::$app->request->getQueryParam('occasion'); ?>
                        <?php foreach (Holiday::find()->all() as $holiday): ?>
                            <option
                                value="<?= Url::to([
                                    '/category/view',
                                    'slug' => $category->slug,
                                    'occasion' => $holiday->id
                                ]) ?>"
                                <?= $currentOccasion == $holiday->id ? ' selected' : '' ?>
                            ><?= $holiday->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="#" class="hidden pjax" data-link="occasion-selector-link"></a>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $recipesProvider]) ?>
    <?php Pjax::end() ?>

    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

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
