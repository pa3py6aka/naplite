<?php
/* @var string $action */
/* @var \core\entities\User\User $user */

use core\helpers\ContentHelper;
use core\helpers\Pluralize;
use core\helpers\UserHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="textbox_nop">
    <div class="userpage_info">
        <div class="userpage_info_left">
            <div class="breadcump">
                <a href="/">Главная</a>
                <!--<span><i class="fa fa-circle"></i></span>
                <a href="#">Кулинары</a>-->
                <?= ContentHelper::breadcrumbsForUserPages($action, $user) ?>
            </div>
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
                                <a href="<?= $action == 'recipes' ? 'javascript:void(0)' : Url::to(['/users/recipes', 'id' => $user->id]) ?>" class="link_red"<?= $action == 'recipes' ? ' data-link="to-recipes-block"' : '' ?>>
                                    <?= Pluralize::get($user->recipes_count, 'рецепт', 'рецепта', 'рецептов') ?>
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
        <div class="userpage_info_right">
            <ul>
                <li><<?= $action == 'view' ? 'b class="f16"' : 'a href="' . Url::to(['/users/view', 'id' => $user->id]) . '"' ?>>Личная страница</<?= $action == 'view' ? 'b' : 'a' ?>></li>
                <li><<?= $action == 'recipes' ? 'b class="f16"' : 'a href="' . Url::to(['/users/recipes', 'id' => $user->id]) . '"' ?>>Все рецепты автора</<?= $action == 'recipes' ? 'b' : 'a' ?>></li>
                <li><<?= $action == 'cookbook' ? 'b class="f16"' : 'a href="' . Url::to(['/users/cookbook', 'id' => $user->id]) . '"' ?>>Кулинарная книга</<?= $action == 'cookbook' ? 'b' : 'a' ?>></li>
                <li><<?= $action == 'posts' ? 'b class="f16"' : 'a href="' . Url::to(['/users/posts', 'id' => $user->id]) . '"' ?>>Публикации в форуме</<?= $action == 'posts' ? 'b' : 'a' ?>></li>
                <li><<?= $action == 'photos' ? 'b class="f16"' : 'a href="' . Url::to(['/users/photos', 'id' => $user->id]) . '"' ?>>Фотоотчёты</<?= $action == 'photos' ? 'b' : 'a' ?>></li>
            </ul>
            <!-- ToDo: Добавление в друзья и личные сообщения
            <div class="content_buttons_box">
                <a href="javascript:void(0)" class="b_gray"><i class="fa fa-plus-circle"></i>Добавить в друзья</a>
                <a href="javascript:void(0)" class="b_gray"><i class="fa fa-envelope"></i>Написать письмо</a>
            </div>-->
        </div>
    </div>
</div>
