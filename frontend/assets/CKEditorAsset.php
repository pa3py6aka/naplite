<?php

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class CKEditorAsset extends AssetBundle
{
    public $basePath = '@webroot/js/ckeditor';
    public $baseUrl = '@web/js/ckeditor';

    public $js = [
        'ckeditor.js',
    ];
    public $css = [];

    public $depends = [
        AppAsset::class,
    ];
}