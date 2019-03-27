<?php

use core\helpers\BlogHelper;
use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\BlogCategoriesWidget;
use widgets\Pager;
use widgets\SidebarCollectionsWidget;
use widgets\SocialBlockWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $user \core\entities\User\User */
/* @var $provider \yii\data\ActiveDataProvider */

/* @var $report \core\entities\Recipe\PhotoReport */

$this->title = $user->fullName . ' | Фотоотчёты';
\frontend\assets\LightBoxAsset::register($this);

?>
<div class="content_left" id="blogsListPage">
    <?= $this->render('user-top-block', ['action' => 'photos', 'user' => $user]) ?>
    <div class="textbox">
        <div class="th_2col">
            <h2>Фотоотчёты</h2>
        </div>
        <div class="p40"></div>
        <ul class="photoreport">
            <?php if (!count($provider->models)): ?>
                <div class="no-counts">
                    <?php if (Yii::$app->user->id === $user->id): ?>
                        <?= Yii::$app->settings->get('emptyBlockForPhotos') ?>
                    <?php else: ?>
                        Пользователь не добавил ещё фото-отчётов
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($provider->models as $report): ?>
                    <?= $this->render('@frontend/views/photo-reports/report-item', ['report' => $report]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="cb"></div>
        <div class="p40"></div>
    </div>

    <?php if (Yii::$app->settings->get('bannerPagenator_show')) {
        echo Yii::$app->settings->get('bannerPagenator');
    } ?>

    <?= Pager::widget(['pagination' => $provider->pagination]) ?>

    <div class="p40"></div>

    <?= ArticlesWidget::widget() ?>

</div>
<div class="content_right">

    <?= BannerWidget::widget(['type' => BannerWidget::TYPE_RIGHT, 'bannerId' => 'bannerSimple1']) ?>

    <?= BestChefsWidget::widget() ?>
    <div class="p40"></div>

    <?= SocialBlockWidget::widget() ?>

    <?= SidebarCollectionsWidget::widget() ?>

</div>
