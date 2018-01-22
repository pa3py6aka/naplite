<?php

namespace widgets;


use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class BannerWidget extends Widget
{
    public $type;

    const TYPE_RIGHT = 'right_banner';

    public function init()
    {
        if (empty($this->type)) {
            throw new InvalidConfigException("Не указан тип баннера");
        }
    }

    public function run()
    {
        $width = $this->type == self::TYPE_RIGHT ? '240' : '';
        $height = $this->type == self::TYPE_RIGHT ? '400' : '';

        return Html::a(
            Html::img('/img/banner-naplite.jpg', ['width' => $width, 'height' => $height]),
            'javascript:void(0)',
            ['class' => $this->type]
        );
    }
}