<?php

namespace widgets;


use yii\base\Widget;

class RecipeThemesWidget extends Widget
{
    public function run()
    {
        return $this->render('recipe-themes-block');
    }
}