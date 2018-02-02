<?php

use widgets\ArticlesWidget;
use widgets\BannerWidget;
use widgets\BestChefsWidget;
use widgets\Pager;
use widgets\SidebarCollectionsWidget;
use widgets\SocialBlockWidget;

/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */

/* @var $report \core\entities\Recipe\PhotoReport */

$this->title = 'Фотоотчёты';
\frontend\assets\LightBoxAsset::register($this);

?>
<div class="content_left" id="blogsListPage">
    <div class="textbox">
        <div class="th_2col">
            <h2>Фотоотчёты</h2>
        </div>
        <div class="p40"></div>
        <ul class="photoreport">
            <?php if (!count($provider->models)): ?>
                <div class="no-counts">
                    Ещё никто не добавил ни одного фотоотчёта :(
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
    <div class="p40"></div>

    <?= SidebarCollectionsWidget::widget() ?>

</div>
