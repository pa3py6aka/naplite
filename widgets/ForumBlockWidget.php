<?php

namespace widgets;


use yii\base\Widget;

class ForumBlockWidget extends Widget
{
    public $blogs;

    public function run()
    {
        return $this->render('forum-block');
    }
}