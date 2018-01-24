<?php

namespace widgets;


use yii\base\Widget;

class IngredientsBlockWidget extends Widget
{
    public function run()
    {
        return $this->render('ingredients-block');
    }
}