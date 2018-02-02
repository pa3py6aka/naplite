<?php

use backend\assets\LightBoxAsset;
use core\entities\Recipe\PhotoReport;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\PhotoReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотоотчёты';
$this->params['breadcrumbs'][] = $this->title;

LightBoxAsset::register($this);

?>
<div class="photo-report-index box box-primary">
    <div class="box-body table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                //'id',
                [
                    'label' => 'Фото',
                    'value' => function(PhotoReport $report) {
                        $img = Html::img($report->getImageUrl(true, true), [
                            'class' => 'img-responsive',
                            'style' => 'height:150px;'
                        ]);
                        return Html::a($img, $report->getImageUrl(false, true), ['data-lightbox' => 'image-' . $report->id,]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Рецепт',
                    'attribute' => 'recipe',
                    'value' => function (PhotoReport $report) {
                        return Html::a(Html::encode($report->recipe->name), ['/recipe/view', 'id' => $report->recipe_id]);
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'recipe',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/recipe/auto-complete', {
                                    username: request.term
                                }, response);
                            }")
                        ],
                        'options' => [
                            'class' => 'form-control',
                        ]
                    ]),
                ],
                [
                    'label' => 'Автор',
                    'attribute' => 'user',
                    'value' => function (PhotoReport $report) {
                        return Html::a(Html::encode($report->user->fullName), ['/user/view', 'id' => $report->user_id]);
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'user',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/user/auto-complete', {
                                    username: request.term
                                }, response);
                            }")
                        ],
                        'options' => [
                            'class' => 'form-control',
                        ]
                    ]),
                ],
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'attribute2' => 'date_to',
                        'type' => DatePicker::TYPE_RANGE,
                        'separator' => '-',
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            'format' => 'dd.mm.yyyy',
                        ],
                    ]),
                    'format' => 'datetime',
                ],

                ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
            ],
        ]); ?>
    </div>
</div>
