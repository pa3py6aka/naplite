<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'font-awesome-4.7.0/css/font-awesome.min.css',
        'fixes.css',
    ];
    public $js = [
        //'js/magnific.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
