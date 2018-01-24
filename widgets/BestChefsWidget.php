<?php

namespace widgets;


use yii\base\Widget;

class BestChefsWidget extends Widget
{
    public function run()
    {
        return $this->render('best-chefs-block');
    }
}