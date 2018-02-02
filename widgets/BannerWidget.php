<?php

namespace widgets;


use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class BannerWidget extends Widget
{
    public $type;
    public $bannerId;

    const TYPE_RIGHT = 'right_banner';

    public function init()
    {
        if (empty($this->type)) {
            throw new InvalidConfigException("Не указан тип баннера");
        }
    }

    public function run()
    {
        //echo $this->bannerId . '_show<br>';
        //echo Yii::$app->settings->get($this->bannerId . '_show');exit;
        if (!Yii::$app->settings->get($this->bannerId . '_show')) {
            return '';
        }

        return Html::a(
            Yii::$app->settings->get($this->bannerId),
            'javascript:void(0)',
            ['class' => $this->type]
        ) . '<div class="p40"></div>';
    }
}