<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class PhotoboxAsset extends AssetBundle
{
    public $basePath = '@webroot/js/photobox';
    public $baseUrl = '@web/js/photobox';

    public $js = [
        'photobox.js',
    ];

    public $css = [
        'photobox.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
