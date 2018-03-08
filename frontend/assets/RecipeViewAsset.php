<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class RecipeViewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/recipe_view.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        //LightBoxAsset::class,
        PhotoboxAsset::class,
    ];
}
