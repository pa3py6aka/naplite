<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class RecipeCreatorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/recipe_creator.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
