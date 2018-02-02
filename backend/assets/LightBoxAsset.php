<?php

namespace backend\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class LightBoxAsset extends AssetBundle
{
    public $basePath = '@webroot/js/lightbox';
    public $baseUrl = '@web/js/lightbox';

    public $js = [
        'js/lightbox.min.js',
    ];
    public $css = [
        'css/lightbox.min.css'
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}