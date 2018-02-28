<?php

use core\helpers\SortHelper;
use widgets\BannerWidget;
use widgets\UserRightMenuWidget;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
/* @var $category \core\entities\Recipe\Category|null */
/* @var $user \core\entities\User\User */
/* @var $userCategories \core\entities\Recipe\Category[] */

$this->title = $user->fullName . ' | Кулинарная книга';
$this->title .= $category ? ' | ' .$category->getHeadingTile() : '';
?>
<div class="content_left">
    <?= $this->render('adaptive-menu', ['userId' => $user->id]) ?>
    <div class="textbox_nop">
        <div class="userpage_info">
            <div class="userpage_info_left">
                <div class="cb"><h1>Кулинарная книга</h1></div>

                <?php Pjax::begin([
                    'linkSelector' => '.pjax'
                ]) ?>
                <div class="sort_panel">
                    <div class="sort_panel_left">
                        <div class="inputbox_2_col">
                            <div class="inputbox_label_left">Показывать:</div>
                            <div class="inputbox_label_right">
                                <select name="sort-selector" class="select_base" data-for-link="sort-selector-link">
                                    <option value="<?= SortHelper::getUrl($provider->sort, 'id') ?>"<?= $provider->sort->getAttributeOrder('id') == SORT_DESC ? ' selected' : '' ?>>Самые новые</option>
                                    <option value="<?= SortHelper::getUrl($provider->sort, 'rate') ?>"<?= $provider->sort->getAttributeOrder('rate') == SORT_DESC ? ' selected' : '' ?>>Самые популярные</option>
                                    <option value="<?= SortHelper::getUrl($provider->sort, 'comments_count') ?>"<?= $provider->sort->getAttributeOrder('comments_count') == SORT_DESC ? ' selected' : '' ?>>Самые обсуждаемые</option>
                                </select>
                                <a href="#" class="hidden pjax" data-link="sort-selector-link"></a>
                            </div>
                        </div>
                    </div>
                    <div class="sort_panel_right">
                        <div class="inputbox_2_col">
                            <div class="inputbox_label_left">Категории:</div>
                            <div class="inputbox_label_right">
                                <select name="occasion-selector" class="select_base" data-for-link="occasion-selector-link">
                                    <option value="<?= Url::to(['/users/cookbook', 'id' => $user->id]) ?>">Все рецепты</option>
                                    <?php foreach ($userCategories as $userCategory): ?>
                                        <option
                                                value="<?= Url::to([
                                                    '/users/cookbook',
                                                    'id' => $user->id,
                                                    'category' => $userCategory->slug,
                                                ]) ?>"
                                            <?= $category && $category->id == $userCategory->id ? ' selected' : '' ?>
                                        ><?= $userCategory->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <a href="#" class="hidden pjax" data-link="occasion-selector-link"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!count($provider->models)): ?>
                    <div class="no-counts">
                        <?php if (Yii::$app->user->id === $user->id): ?>
                            <?= Yii::$app->settings->get('emptyBlockForCookbook') ?>
                        <?php else: ?>
                            Пользователь не добавил ещё рецептов в свою кулинарную книгу
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $provider]) ?>
                <?php endif; ?>

                <?php Pjax::end() ?>
            </div>
        </div>
    </div>
</div>
<div class="content_right">
    <?= UserRightMenuWidget::widget(['userId' => $user->id]) ?>
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>
</div>
