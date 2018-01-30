<?php

/* @var $this yii\web\View */

use core\entities\Article\Article;
use core\entities\Recipe\Recipe;
use core\entities\User\User;
use yii\helpers\Url;

$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= User::find()->count() ?></h3>
                <p>Всего пользователей</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="<?= Url::to(['/user/index']) ?>" class="small-box-footer">
                Управление <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= Recipe::find()->count() ?></h3>

                <p>Количество рецептов</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-restaurant"></i>
            </div>
            <a href="<?= Url::to(['/recipe/index']) ?>" class="small-box-footer">
                Управление <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= \core\entities\Blog\Blog::find()->count() ?></h3>

                <p>Количество постов</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-list-outline"></i>
            </div>
            <a href="<?= Url::to(['/blog/index']) ?>" class="small-box-footer">
                Управление <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= Article::find()->count() ?></h3>

                <p>Количество статей</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-paper-outline"></i>
            </div>
            <a href="<?= Url::to(['/article/index']) ?>" class="small-box-footer">
                Управление <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-12">
        <p><a href="https://metrika.yandex.ru" target="_blank" class="style-link link-ya-metrica">Яндекс.Метрика</a></p>
    </div>
</div>
