<?php

use core\helpers\Pluralize;
use core\helpers\UserHelper;
use widgets\BannerWidget;
use widgets\ForumBlockWidget;
use widgets\UserRightMenuWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $recipesProvider \yii\data\ActiveDataProvider */

$this->title = $user->fullName . ' | ' . Yii::$app->name;

?>
<div class="content_left">
    <?= $this->render('adaptive-menu', ['userId' => $user->id]) ?>
    <div class="textbox_nop">
        <div class="userpage_info">
            <div class="userpage_info_left">
                <div class="userpage_info_left_inner">
                    <div class="userpage_info_left_inner_left">
                        <h1><?= $user->fullName ?></h1>
                        <div class="userpage_userpickbox_adaptive">
                            <img src="<?= $user->avatarUrl ?>" width="200" height="200" alt="<?= $user->fullName ?>"/>
                        </div>
                        <span class="userpage_city"><?= UserHelper::getResidency($user) ?></span>
                        <span class="userpage_stat">
                            <span class="userpage_stat_left"><i class="fa fa-graduation-cap"></i><?= $user->experience->name ?></span>
                            <span class="userpage_stat_right">
                                <a href="javascript:void(0)" class="link_red" data-link="to-recipes-block">
                                    <?= Pluralize::get($recipesProvider->totalCount, 'рецепт', 'рецепта', 'рецептов') ?>
                                </a>
                            </span>
                        </span>
                        <span class="userpage_about_user"><?= Html::encode($user->about) ?></span>
                    </div>
                    <div class="userpage_info_left_inner_right">
                        <div class="userpage_userpickbox">
                            <img src="<?= $user->avatarUrl ?>" width="200" height="200" alt="<?= $user->fullName ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span id="startRecipesBlock"></span>
    <?php if (!$recipesProvider->totalCount): ?>
        <div class="info_text">
            <?= $user->id === Yii::$app->user->id ?
                "Здесь будут показаны ваши рецепты,<br />добавьте прямо сейчас любой рецепт,<br />чтобы начать общаться На плите!" :
                "Пользователь еще не добавлял рецептов" ?>
        </div>
    <?php else: ?>
        <?php Pjax::begin(['linkSelector' => '.pjax']) ?>
        <?= $this->render('@frontend/views/recipes/recipes-block', ['recipesProvider' => $recipesProvider]) ?>
        <?php Pjax::end() ?>

        <?php /* ToDo Сделать ajax-загрузку рецептов вместо пагинации
        <div class="cb tac">
            <a href="#" class="b_brown b_shadow"><i class="fa fa-refresh"></i>Показать больше рецептов</a>
        </div>
        */ ?>
    <?php endif; ?>
    <div class="p40"></div>

    <?= ForumBlockWidget::widget() ?>
</div>
<div class="content_right">
    <?= UserRightMenuWidget::widget(['userId' => $user->id]) ?>
    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>
</div>

