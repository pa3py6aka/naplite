<?php

namespace widgets;


use yii\base\Widget;

class SocialBlockWidget extends Widget
{
    public function run()
    {
        return $this->render('social-block');
    }
}