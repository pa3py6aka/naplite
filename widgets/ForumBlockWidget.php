<?php

namespace widgets;


use core\repositories\BlogRepository;
use yii\base\Widget;

class ForumBlockWidget extends Widget
{
    public function run()
    {
        $blogs = BlogRepository::getLast();
        return $this->render('forum-block' , ['blogs' => $blogs]);
    }
}