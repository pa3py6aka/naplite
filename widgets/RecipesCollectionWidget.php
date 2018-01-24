<?php

namespace widgets;


use yii\base\Widget;

class RecipesCollectionWidget extends Widget
{
    public function run()
    {
        return $this->render('recipes-collection-block');
    }
}