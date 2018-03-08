<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class RecipeCreatorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/recipe_creator.js',
        //'js/select2.full.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
        'js/select2.muilti-checkboxes.js',
    ];

    public $css = [
        'css/select2.min.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        CKEditorAsset::class
    ];
}
