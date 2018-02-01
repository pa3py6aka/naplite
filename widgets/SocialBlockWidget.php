<?php

namespace widgets;


use yii\base\Widget;
use yii\web\View;

class SocialBlockWidget extends Widget
{
    public function run()
    {
        $this->view->registerJsFile('//vk.com/js/api/openapi.js?152', ['position' => View::POS_HEAD]);
        return $this->render('social-block');
    }
}