<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class CropperAsset extends AssetBundle
{
    public $basePath = '@webroot/js/cropper';
    public $baseUrl = '@web/js/cropper';

    public $js = [
        'min.js',
    ];

    public $css = [
        'min.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
